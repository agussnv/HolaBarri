<template>
    <main>
        <div
            class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1 mt-16">
                <div class="mb-4">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Comandes</h1>
                </div>
                <!-- Barra de búsqueda + botones -->
                <div
                    class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                    <div class="flex items-center mb-4 sm:mb-0">
                        <form class="sm:pr-3" action="#" method="GET">
                            <label for="products-search" class="sr-only">Buscar</label>
                            <div class="flex items-center relative w-48 mt-1 sm:w-64 xl:w-96">
                                <div
                                    class="relative w-full flex items-center shadow-sm rounded-lg overflow-hidden border border-gray-200 focus-within:ring-2 focus-within:ring-blue-400 focus-within:border-blue-400 transition duration-150">
                                    <!-- Icono de búsqueda -->
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <!-- Input -->
                                    <input v-model="searchTerm" @keyup.enter="" type="text" name="search" id="order-search"
                                        class="w-full py-3 pl-10 pr-10 text-gray-700 bg-white focus:outline-none placeholder-gray-400"
                                        placeholder="Buscar comandes...">
                                    <!-- Botón de limpiar -->
                                    <button v-if="searchTerm" @click="clearSearch"
                                        class="absolute right-0 h-full px-3 flex items-center justify-center text-red-500 hover:text-red-700 focus:outline-none transition duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        CLIENT
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        DATA
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        TIPUS
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        TOTAL
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        ESTAT
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        ACCIONS
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                <tr v-for="order in filteredOrders" class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        #{{ order.id }}</td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ order.order.cliente.name }} {{ formatApellido(order.order.cliente.apellidos)
                                        }}</td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ formatFecha(order.created_at) }}</td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ order.order.tipo_envio.nombre }}</td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ order.subtotal }}</td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                        <!-- {{ order.estat_compra.nombre }} -->
                                        <select id="estat" v-model="order.estat_compra.id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                            <option v-for="estat in estats" :key="estat.id" :value="estat.id"
                                                data-v-inspector="pages/admin/productes.vue:358:29">
                                                {{ estat.nombre }}
                                            </option>
                                        </select>

                                    </td>

                                    <td class="p-4 space-x-2 whitespace-nowrap flex">
                                        <NuxtLink v-if="order?.id" :to="`/admin/comandes/${order.id}`" id="viewOrder"
                                            class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <g clip-path="url(#clip0_429_11160)">
                                                        <circle cx="12" cy="11.9999" r="9" stroke="#ffffff"
                                                            stroke-width="2.5" stroke-linecap="round"
                                                            stroke-linejoin="round"></circle>
                                                        <rect x="12" y="8" width="0.01" height="0.01" stroke="#ffffff"
                                                            stroke-width="3.75" stroke-linejoin="round"></rect>
                                                        <path d="M12 12V16" stroke="#ffffff" stroke-width="2.5"
                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_429_11160">
                                                            <rect width="24" height="24" fill="white"></rect>
                                                        </clipPath>
                                                    </defs>
                                                </g>
                                            </svg>
                                            Veure comanda
                                        </NuxtLink>
                                        <button type="button" id="updateOrderEstat" :disabled="isDisabled(order.id)"
                                            @click="guardarEstat(order.id)"
                                            class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50 disabled:cursor-not-allowed">
                                            <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M18.1716 1C18.702 1 19.2107 1.21071 19.5858 1.58579L22.4142 4.41421C22.7893 4.78929 23 5.29799 23 5.82843V20C23 21.6569 21.6569 23 20 23H4C2.34315 23 1 21.6569 1 20V4C1 2.34315 2.34315 1 4 1H18.1716ZM4 3C3.44772 3 3 3.44772 3 4V20C3 20.5523 3.44772 21 4 21L5 21L5 15C5 13.3431 6.34315 12 8 12L16 12C17.6569 12 19 13.3431 19 15V21H20C20.5523 21 21 20.5523 21 20V6.82843C21 6.29799 20.7893 5.78929 20.4142 5.41421L18.5858 3.58579C18.2107 3.21071 17.702 3 17.1716 3H17V5C17 6.65685 15.6569 8 14 8H10C8.34315 8 7 6.65685 7 5V3H4ZM17 21V15C17 14.4477 16.5523 14 16 14L8 14C7.44772 14 7 14.4477 7 15L7 21L17 21ZM9 3H15V5C15 5.55228 14.5523 6 14 6H10C9.44772 6 9 5.55228 9 5V3Z"
                                                        fill="#ffffff"></path>
                                                </g>
                                            </svg>
                                            Guardar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<style scoped>
.contain-data {
    background-color: rgb(31 41 55 / var(--tw-bg-opacity, 1));
    width: 100%;
    height: 80vh;
    display: flex;
    flex-direction: column;
    padding: 1.5rem;
    overflow-y: auto;
}

.contain-products {
    --tw-bg-opacity: 1;
    border: 1px solid #54585e;
    width: 100%;
    max-height: 50%;
    overflow-y: auto;
}

.producto {
    display: flex;
    background-color: rgb(55 65 81 / var(--tw-bg-opacity, 1));
    padding: 0.85rem;
    /* align-items: center; */
    justify-content: space-between;
}

.contain-text {
    margin-left: 1rem;
}

.contain-image {
    width: 80px;
    height: 80px;
    overflow: hidden;
}
</style>

<script setup>
import socket from '~/socket';

const { $communicationManager } = useNuxtApp();
const auth = useAuthStore();
const searchTerm = ref('');

definePageMeta({
    layout: 'admin',
});

const backgroundShadow = ref(false);

console.log("Socket Connected: ", socket.connected);

socket.on('connect', () => {
    console.log("Socket conectado con id: ", socket.id);
});

if (socket.connected) {
    // console.log("Socket está conectado correctamente.");
    socket.emit("identificarUsuario", { user_id: auth.user.id });
} else {
    console.log("Socket no está conectado.");
}

const isOpen = reactive({
    'info': false,
});

function toggleCard(menu) {
    isOpen[menu] = !isOpen[menu];
    backgroundShadow.value = !backgroundShadow.value
}

const orders = ref([]);
const actualOrder = reactive({});
const estats = reactive([]);
const estatsOriginals = reactive([])

const subtotal = computed(() => {
    if (!actualOrder.productos_compra) {
        return 0;
    }
    return actualOrder.productos_compra.reduce((total, productoInfo) => {
        return total + productoInfo.cantidad * productoInfo.precio;
    }, 0);
});

const formatFecha = (fecha) => {
    if (!fecha) return ""; // Manejar el caso de fecha nula o indefinida
    const date = new Date(fecha);

    const dia = String(date.getDate()).padStart(2, "0");
    const mes = String(date.getMonth() + 1).padStart(2, "0"); // Los meses empiezan en 0
    const año = date.getFullYear();

    const horas = String(date.getHours()).padStart(2, "0");
    const minutos = String(date.getMinutes()).padStart(2, "0");

    return `${dia}/${mes}/${año} ${horas}:${minutos}`;
};

const formatApellido = (apellidos) => {
    if (!apellidos) return ""; // Maneja casos donde no hay apellidos
    return `${apellidos[0].toUpperCase()}.`; // Toma la primera letra y agrega un punto
};

function isDisabled(id) {
    const order = orders.value.find(order => order.id === id);
    if (estatsOriginals[id] !== order.estat_compra.id) {
        return false;
    }
    return true;
}

async function guardarEstat(id) {
    const order = orders.value.find(order => order.id === id);
    order.estat = order.estat_compra.id;
    estatsOriginals[order.id] = order.estat;

    if (estatsOriginals[order.id] === 4 || estatsOriginals[order.id] === 5) {
        delete estatsOriginals[order.id];
    }
    orders.value = orders.value.filter(order => order.estat !== 4 && order.estat !== 5);

    const data = await $communicationManager.updateOrder(order);
}

onMounted(async () => {
    document.addEventListener('keydown', closeAll);
    const data = await $communicationManager.getEstats();
    estats.push(...data.data);
    socket.on("nuevaOrdenRecibida", (newSuborder) => {
        orders.value.push(newSuborder);
        estatsOriginals[newSuborder.id] = newSuborder.estat_compra.id;
    });
})

onBeforeMount(async () => {
    const data = await $communicationManager.getOrders();
    orders.value.push(...data.data);
    orders.value.forEach(order => {
        estatsOriginals[order.id] = order.estat;
    });
})

const closeAll = (e) => {
    if (e.key === "Escape") {
        isOpen['info'] = false;
        backgroundShadow.value = false;
    }
};

const clearSearch = () => {
    searchTerm.value = '';
};

function removeAccents(str) {
    return str.normalize("NFD").replace(/[\u0300-\u036f]/g, '');
}

const filteredOrders = computed(() => {
    if (!searchTerm.value) return orders.value;
    const st = removeAccents(searchTerm.value.toLowerCase());
    return orders.value.filter(order => {
        const id = String(order.id).toLowerCase();
        const clienteName = removeAccents(order.order?.cliente?.name?.toLowerCase() || '');
        return id.includes(st) || clienteName.includes(st);
    });
});
</script>