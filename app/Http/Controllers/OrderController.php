<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Exports\OrderstsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class OrderController extends Controller
{
    public function index(Request $request) {
        $orders = new Order();
        if($request->start_date) {
            $orders = $orders->where('created_at', '>=', $request->start_date);
        }
        if($request->end_date) {
            $orders = $orders->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }
        $orders = $orders->with(['items', 'payments', 'customer'])->latest()->paginate(10);

        $total = $orders->map(function($i) {
            return $i->total();
        })->sum();
        $receivedAmount = $orders->map(function($i) {
            return $i->receivedAmount();
        })->sum();

        return view('orders.index', compact('orders', 'total', 'receivedAmount'));
    }

    public function store(OrderStoreRequest $request)
    {
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'user_id' => $request->user()->id,
        ]);

        $cart = $request->user()->cart()->get();
        foreach ($cart as $item) {
            $order->items()->create([
                'price' => $item->price * $item->pivot->quantity,
                'quantity' => $item->pivot->quantity,
                'product_id' => $item->id,
            ]);
            $item->quantity = $item->quantity - $item->pivot->quantity;
            $item->save();
        }
        $request->user()->cart()->detach();
        $order->payments()->create([
            'amount' => $request->amount,
            'user_id' => $request->user()->id,
        ]);
        return 'success';
    }
    public function export() 
    {
        return Excel::download(new OrderExport, 'orders.xlsx');
    }
    public function exportPdf(Request $request)
    {
        $orders = Order::query();

        if ($request->start_date) {
            $orders = $orders->where('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $orders = $orders->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        $orders = $orders->with(['items', 'payments', 'customer'])->get();

        $html = view('orders.pdf', compact('orders'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output('orders.pdf', 'I');
    }
    public function showOrderDetails($id)
    {
        $order = Order::with(['items.product', 'payments', 'customer'])->findOrFail($id);
        return view('orders.details', compact('order'));
    }
}
