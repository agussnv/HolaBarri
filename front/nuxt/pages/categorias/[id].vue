<template>
    <div class="p-6">
        <p @click="todasLasCategorias()" class="text-blue-500 cursor-pointer hover:underline mb-4">
            Veure totes les categories
        </p>

        <div v-if="isLoading" class="flex justify-center items-center py-10">
            <loading />
        </div>

        <div v-else-if="comercios.length" class="space-y-4">
            <h2 class="text-xl font-bold">Llista de comerços</h2>
            <div class="overflow-x-auto whitespace-nowrap">
                <ul class="flex space-x-4">
                    <li v-for="comercio in comercios" :key="comercio.id"
                        class="min-w-[300px] bg-white shadow-lg p-4 border border-gray-200 flex-shrink-0"
                        @click="router.push(`/comercio/${comercio.id}`)">
                        <h3 class="text-lg font-semibold text-gray-800">{{ comercio.nombre }}</h3>
                        <p class="text-sm"><strong>Adreça:</strong>
                            {{ comercio.calle_num }}, {{ comercio.ciudad }}
                        </p>
                        <p class="text-sm"><strong>Puntuació mitjana:</strong> ⭐ {{ comercio.puntaje_medio }}</p>
                    </li>
                </ul>
            </div>
        </div>

        <div v-if="productos.length" class="mt-8">
            <h2 class="text-xl font-bold mb-4">Últimes tendències</h2>
            <div class="grid grid-cols-2 gap-4">
                <producto-comp v-for="producto in productos" :key="producto.id"
                    :img="producto.imagen ? `${baseUrl}/storage/${producto.imagen}` : `${baseUrl}/storage/productos/default-image.webp`"
                    :title="producto.nombre" :price="producto.precio" :comercio="producto.comercio_nombre"
                    @click="mostrarIdProducto(producto.id)" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { useRouter, useRoute } from 'vue-router';
import { ref, onMounted } from 'vue';
import loading from '../../components/loading.vue';
import { useAuthStore } from '../../stores/authStore';
import productoComp from '../../components/productoComp.vue';

import { useRuntimeConfig } from "#imports";
const config = useRuntimeConfig();
const baseUrl = config.public.apiBaseUrl;

const route = useRoute();
const router = useRouter();
const comercios = ref([]);
const productos = ref([]);
const isLoading = ref(true);
const authStrore = useAuthStore();
const { $communicationManager } = useNuxtApp();

console.log(authStrore.user.codigo_postal);

async function getComerciosCategoria() {
    try {
        const categoriaId = route.params.id;
        const response = await $communicationManager.getComerciosDeCategorias(categoriaId);
        const responseProductos = await $communicationManager.getProductosDeCategorias(categoriaId);

        console.log(responseProductos);

        if (Array.isArray(response)) {
            comercios.value = response;
        } else {
            console.error("La respuesta de comercios no es un array");
        }

        if (Array.isArray(responseProductos)) {
            productos.value = responseProductos;
        } else {
            console.error("La respuesta de productos no es un array");
        }
    } catch (error) {
        console.error("Error obteniendo datos:", error);
    } finally {
        isLoading.value = false;
    }
}

function todasLasCategorias() {
    router.push(`/categorias`);
}

function mostrarIdProducto(id) {
    router.push(`/producto/${id}`);
}

onMounted(() => {
    getComerciosCategoria();
});
</script>