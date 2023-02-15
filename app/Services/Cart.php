<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;


class Cart
{
    // variable de tipo Collection para guardar y recuperar informacion
    protected Collection $cart;

    // constructor del carrito
    public function __construct()
    {
        //valida si en sesion ya tenemos el carrito y le asignamos la informacion
        if (session()->has("cart")) {
            $this->cart = session("cart");
        } else {
            $this->cart = new Collection;
        }
    }

    // recupera contenido del carrito
    public function getContent(): Collection
    {
        //retorna el carrito que tenemos en cart pero ordenado de forma alfabetica

            return $this->cart->sortBy(['name', ['name', 'asc']]);
    }

    // guardar el carrito en sesion
    protected function save(): void
    {
        session()->put("cart", $this->cart);
        session()->save();
    }


    // agregar un producto al carrito
    public function addProduct(Product $product, $cant = 1, $changes = 0): void
    {
        //variable pre crea un array con el producto y la cantidad
        $pre = Arr::add($product, 'qty', 1);
        //valida que antes de agregar un producto al carrito vea si es correcta la informacion
        $this->validate($pre);
        //se agrega el producto
        $this->cart->push($pre);
        $this->save();
    }

    // agregar cambios a un producto
    public function addChanges($id, $changes)
    {
         //se almacena de manera temporal
        $mycart = $this->getContent();
        $oldItem = $mycart->where('id', $id)->first();
        $newItem = $oldItem;
        $newItem->changes = $changes;

        //metodo que elimina el producto
        $this->removeProduct($id);
        $this->addProduct($newItem);
    }
    public function removeChanges($id)
    {
        $mycart = $this->getContent();
        $oldItem = $mycart->where('id', $id)->first();
        $newItem = $oldItem;
        $newItem->changes = '';
        $this->removeProduct($id);
        $this->addProduct($newItem);
    }



    // valida si existe X producto en carrito y retorna si xiste o no
    public function existsInCart(int $id): bool
    {
        $mycart = $this->getContent();
        //consulta producta que estan pasando
        $cont = $mycart->where('id', $id)->count();
        $res = $cont > 0 ? true : false;

        return $res;
    }

    // cantidad de X producto agregada al carrito
    public function countInCart(int $id): int
    {
        $mycart = $this->getContent();
        //qty=cantidad
        $cont = $mycart->where('id', $id)->sum('qty');
        return $cont;
    }


    // incrementar cantidad de X producto en carrito
    public function updateQuantity($id, $cant = 1): void
    {
        $mycart = $this->getContent();
        $oldItem = $mycart->where('id', $id)->first();
        $newItem = $oldItem;
        $newItem->qty += $cant;
        $this->removeProduct($id);
        $this->addProduct($newItem);
    }

    // decrementar cantidad de X producto en carrito
    public function decreaseQuantity($id, $cant = 1)
    {
        $mycart = $this->getContent();
        $oldItem = $mycart->where('id', $id)->first();
        $newItem = $oldItem;
        $newItem->qty -= $cant;
        $this->removeProduct($id);
        if ($newItem->qty > 0) $this->addProduct($newItem);
    }

    // reemplazar cantidad de X producto en carrito
    public function replaceQuantity($id, $cant = 1): void
    {
        $mycart = $this->getContent();
        $oldItem = $mycart->where('id', $id)->first();
        $newItem = $oldItem;
        $newItem->qty = $cant;
        $this->validate($newItem);
        $this->removeProduct($id);
        $this->addProduct($newItem);
    }



    // elimina producto del carrito
    public function removeProduct(int $id): void
    {
        $this->cart = $this->cart->reject(function (Product $product) use ($id) {
            return $product->id === $id;
        });
        $this->save();
    }

    // obtiene total en carrito
    public function totalAmount()
    {

        $amount = $this->cart->sum(function ($product) {
            return ($product->price * $product->qty);
        });
        return $amount;
    }



    // obtiene el cantidad de filas en carrito
    public function hasProducts(): int
    {
        return $this->cart->count();
    }

    // obtiene sumatoria de productos en carrito
    public function totalItems(): int
    {

        $items = $this->cart->sum(function ($product) {
            //suma la cantidad de las filas
            return $product->qty;
        });
        return $items;
    }

    // vaciar carrito
    public function clear(): void
    {
        $this->cart = new Collection;
        $this->save();
    }



    // validacion antes de agregar item al carrito
    protected function validate($item)
    {
        $validator = Validator::make($item->toArray(), [
            'id' => 'required',
            'price' => 'required|numeric',
            'qty' => 'required|numeric|min:1',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            throw new \ErrorException($validator->messages());
        }

        return $item;
    }
}
