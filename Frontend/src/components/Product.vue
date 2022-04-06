<template>
    <div v-if="products" class="container">
        <header class="jumbotron">
            <h3>
                <strong>Product page</strong>
            </h3>
        </header>
        <div class="row mt-4">
            <div class="mb-4 w-100">
                <button class="float-right" @click="handleCreate">Create New</button>
            </div>
            <div class="col-sm-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>CreatedAt</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products" :key="product.id" :item="product">
                            <td>{{ product.id }}</td>
                            <td>{{ product.name }}</td>
                            <td>{{ product.description }}</td>
                            <td>{{ product.created_at }}</td>
                            <td><button @click="handleDelete(product.id)">Delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "@vue/reactivity";
import httpService from "../services/http.service";

export default {
    name: "Product",
    setup() {
        let products = ref([]);

        const loadProducts = () => {
            httpService.get("/admin-api/product").then((res) => {
                if (res.data) {
                    products.value = res.data.products;
                }
            });
        };

        const handleDelete = (productId) => {
            httpService.post("/admin-api/product/remove", { id: productId }).then((res) => {
                if (res.data.success) {
                    loadProducts();
                }
            });
        }

        const handleCreate = () => {
            httpService.post("/admin-api/product/create-random", {}).then((res) => {
                if (res.data.success) {
                    loadProducts();
                }
            });
        }

        loadProducts();

        return {
            products,
            loadProducts,
            handleDelete,
            handleCreate,
        };
    },
};
</script>
