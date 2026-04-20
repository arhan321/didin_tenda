<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command; // Pastikan model Order disertakan

class RestoreSoftDeleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:restore-soft-deleted {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore soft deleted records in the Order model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ambil ID dari argument command, jika ada
        $id = $this->argument('id');

        if ($id) {
            // Jika ID diberikan, coba restore record dengan ID tersebut
            $order = Order::withTrashed()->find($id);

            if ($order && $order->trashed()) {
                $order->restore();
                $this->info("Order with ID {$id} has been restored.");
            } else {
                $this->error("No trashed order found with ID {$id}.");
            }
        } else {
            // Jika tidak ada ID, restore semua record yang di-soft delete
            $restoredOrders = Order::onlyTrashed()->restore();
            if ($restoredOrders) {
                $this->info("All trashed orders have been restored.");
            } else {
                $this->info("No trashed orders to restore.");
            }
        }
    }
}
