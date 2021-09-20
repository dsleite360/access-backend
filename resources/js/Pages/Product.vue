<template>
    <app-layout title="Produtos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cadastrar Produto
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-10">
                    <div class="grid md:grid-cols-6">
                        <form @submit.prevent="createProduct">
                            <div>
                                <label for="tipo">Tipo de Produto:</label>
                                <select v-model="product.type" id="tipo">
                                    <option v-for="type in types" :value="type.id" :key="type.id">
                                        {{ type.name }}
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label for="name">Nome:</label>
                                <input v-model="product.name" id="nome" type="text">
                            </div>

                            <div>
                                <label for="price">Preço:</label>
                                <input v-model="product.price" id="price" type="text">
                            </div>

                            <div>
                                <label for="thumb">Imagem:</label>
                                <input @change="getProductThumb" id="thumb" type="file">
                            </div>

                            <div>
                                <label for="qtd">Quantidate:</label>
                                <input v-model="product.qtd" id="qtd" type="number">
                            </div>

                            <button class="bg-green-600 mt-3" type="submit">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import axios from 'axios';

    export default defineComponent({
        data() {
            return {
                types: [],
                thumb: null,
                product: {
                    type: null,
                    name: null,
                    price: null,
                    thumb: null,
                    qtd: null,
                },
            }
        },
        components: {
            AppLayout,
        },
        methods: {
            async getAllTypes() {
                const request = await axios.get('/api/product-types');
                this.types = request.data;
            },
            getProductThumb(event) {
                this.thumb = event.target.files[0];
            },
            async createProduct() {
                const formData = new FormData();

                formData.append('thumb', this.thumb);
                formData.append('name', this.name);
                formData.append('price', this.price);
                formData.append('qtd', this.qtd);

                const request = await axios.post('/api/products', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                });

                console.log(request);
            }
        },
        mounted() {
            this.getAllTypes();
        }
    })
</script>
