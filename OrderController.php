<?php


namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CartItem;

/**
 *
 */
class OrderController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $orders = $this->getOrderPaginate();

        $orderData = $this->serializeOrderData($orders);

        $orderPaginationData = [
            'current_page' => $orders->currentPage(),
            'per_page' => $orders->perPage(),
            'total' => $orders->total(),
            'last_page' => $orders->lastPage(),
            'from' => $orders->firstItem(),
            'to' => $orders->lastItem(),
            'data' => $orderData
        ];

        return view('orders.index', ['orders' => $orderPaginationData]);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private function getOrderPaginate(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        // with method can avoid any lazy loadding and take advantage of eager loading
        return Order::with([
            'customer',
            'item',
            'cart_item' => function ($query) {
                $query->orderByDesc('created_at')->first();
            }
        ])->orderBy('completed_at', 'desc')
            ->paginate(10);
    }

    /**
     * @param mixed $orders
     * @return array
     */
    private function serializeOrderData(mixed $orders): array
    {
        $orderData = [];

        foreach ($orders->items() as $order) {
            $customer = $order->customer;
            $items = $order->items;
            $totalAmount = 0;
            $itemsCount = 0;

            foreach ($items as $item) {
                $totalAmount += $item->price * $item->quantity;
                $itemsCount++;
            }

            $lastAddedToCart = $orders->cartItem->created_at ?? null;

            $completedOrderExists = ($order->status == 'completed');

            $orderData[] = [
                'order_id' => $order->id,
                'customer_name' => $customer->name,
                'total_amount' => $totalAmount,
                'items_count' => $itemsCount,
                'last_added_to_cart' => $lastAddedToCart,
                'completed_order_exists' => $completedOrderExists,
                'created_at' => $order->created_at,
            ];
        }
        return $orderData;
    }
}

