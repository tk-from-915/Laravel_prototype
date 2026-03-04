<?php

namespace App\Application\Product\Commands\DeleteProduct;

use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Product\ValueObjects\ProductId;

class DeleteProductHandler
{
    public function __construct(private readonly ProductRepositoryInterface $products) {}

    public function handle(DeleteProductCommand $command): bool
    {
        $productId = new ProductId($command->id);
        $product   = $this->products->findById($productId)
            ?? throw new \DomainException("Product not found: {$command->id}");

        $this->products->delete($product->id());

        return true;
    }
}
