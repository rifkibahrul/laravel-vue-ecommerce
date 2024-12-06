import "./bootstrap";

import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";
// import { get, post } from "./http.js";
import {post} from "./http.js"; 

Alpine.plugin(collapse);

window.Alpine = Alpine;

document.addEventListener("alpine:init", async () => {
    Alpine.data("toast", () => ({
        visible: false,
        delay: 5000,
        percent: 0,
        interval: null,
        timeout: null,
        message: null,
        close() {
            this.visible = false;
            clearInterval(this.interval);
        },
        show(message) {
            this.visible = true;
            this.message = message;

            if (this.interval) {
                clearInterval(this.interval);
                this.interval = null;
            }
            if (this.timeout) {
                clearTimeout(this.timeout);
                this.timeout = null;
            }

            this.timeout = setTimeout(() => {
                this.visible = false;
                this.timeout = null;
            }, this.delay);
            const startDate = Date.now();
            const futureDate = Date.now() + this.delay;
            this.interval = setInterval(() => {
                const date = Date.now();
                this.percent =
                    ((date - startDate) * 100) / (futureDate - startDate);
                if (this.percent >= 100) {
                    clearInterval(this.interval);
                    this.interval = null;
                }
            }, 30);
        },
    }));

    // Pengelolaan item produk
    Alpine.data("productItem", (product) => {
        return {
            product,    // Menyimpan data produk yang dierima sebagai parameter
            addToCart(quantity = 1) {     // Fungsi untuk menambahkan item ke keranjang belanja
                post(this.product.addToCartUrl, { quantity })   // Kirim permintaan POST ke 'addToCartUrl' dgn jumlah item yang ditentukan
                    .then((result) => {
                        // Event 'cart-change' dengan jumlah item baru di keranjang
                        this.$dispatch("cart-change", { count: result.count });
                        // Event 'notify' untuk menampilkan pesan sukses
                        this.$dispatch("notify", {
                            message: "The item was added into the cart",
                        });
                    })
                    .catch((response) => {
                        console.log(response);
                    });
            },
            removeItemFromCart() {      // Fungsi untuk menghapus item dari keranjang
                post(this.product.removeUrl).then((result) => {
                    this.$dispatch("notify", {
                        message: "The item was removed from cart",
                    });
                    this.$dispatch("cart-change", { count: result.count });
                    this.cartItems = this.cartItems.filter(
                        (p) => p.id !== product.id      // Menghapus item dari daftar 'cartItems'
                    );
                });
            },
            changeQuantity() {
                post(this.product.updateQuantityUrl, {
                    quantity: product.quantity,
                }).then((result) => {
                    this.$dispatch("cart-change", { count: result.count });
                    this.$dispatch("notify", {
                        message: "The item quantity was updated",
                    });
                });
            },
        };
    });
});

Alpine.start();
