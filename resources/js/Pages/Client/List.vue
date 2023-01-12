<script setup>
import { ref, onMounted, computed  } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import ArrowLongRight from '@/Assets/Icons/ArrowLongRight.vue'
import ArrowLongLeft from '@/Assets/Icons/ArrowLongLeft.vue'
import PencilSquare from '@/Assets/Icons/PencilSquare.vue'
import Trash from '@/Assets/Icons/Trash.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ButtonLink from '@/Components/ButtonLink.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';

const clients = ref({data: {data: null}});
const showConfirmDeleteModal = ref(false);
const clientId = ref(0);

const form = useForm({
    searchTerm: ''
});

const showClients = (url) => {
    return axios.get(url).then(response => {
        clients.value = response.data;
    })
    .catch(function(error) {
        clients.value = error.response.data;
    });
};

const deleteClient = (id) => {
    return axios.delete('api/client/'+id).then(response => {
        showConfirmDeleteModal.value = false
        showClients('/api/client')
    });
};

const shouldHidePagination = computed(() => {
    return !clients.value.data.prev_page_url && !clients.value.data.next_page_url;
});

onMounted(() => {
    showClients('/api/client');
});

const cleanLinks = computed(() => {
    const cleanLinks = [...clients.value.data.links];
    cleanLinks.shift();
    cleanLinks.pop();

    return cleanLinks;
});

const getMatchingResults = (input) => {
    if (input.length > 0) {
        showClients('/api/client/search/' + input);
    }else{
        showClients('/api/client');
    }
};

</script>

<template>
    <AppLayout >
        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8 bg-white p-8">
                <div class="grid grid-cols-2 gap-2">
                    <form @submit.prevent="getMatchingResults(form.searchTerm)" class="flex relative w-full">
                        <input 
                        v-model="form.searchTerm"
                        type="search" name="search" 
                        class="border-1 border-teal-400 focus:border-teal-400 transition h-10 px-5 pr-16 rounded-md focus:ring-teal-400 w-full text-black text-md" placeholder="Pesquisar pelo nome ou CPF" />
                        <button 
                            type="submit" class="absolute right-2 top-2 mr-4">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                            <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                            </svg>
                        </button>
                    </form>
                    <ButtonLink :href="route('clients.create')">Novo cliente</ButtonLink>
                </div>
                <div v-if="clients.data"
                    class="overflow-hidden flex items-center justify-center">
                    <div class="container">
                        <table class="w-full flex flex-row flex-no-wrap sm:bg-white rounded-lg overflow-hidden sm:shadow-lg my-5">
                            <thead class="text-white">
                                <tr v-for="(item, index) in clients.data.data" :key="index" 
                                    class="text-sm bg-teal-400 flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                                    <th class="p-3 text-left">Name</th>
                                    <th class="p-3 text-left">CPF</th>
                                    <th class="p-3 text-left">Data de nascimento</th>
                                    <th class="p-3 text-left">Telefone</th>
                                    <th class="p-3 text-left" width="110px">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="flex-1 sm:flex-none text-sm">
                                <tr v-for="(item, index) in clients.data.data" :key="index" 
                                    class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                                    <td class="border-grey-light border hover:bg-gray-100 p-3">{{ item.name }}</td>
                                    <td class="border-grey-light border hover:bg-gray-100 p-3">{{ item.cpf }}</td>
                                    <td class="border-grey-light border hover:bg-gray-100 p-3 truncate"> {{  item.birth_date }}</td>
                                    <td class="border-grey-light border hover:bg-gray-100 p-3 truncate"> {{  item.phone_number }}</td>
                                    <td class="border-grey-light border p-3">
                                        <div class="grid grid-cols-2 gap-2">
                                            <a :href="route('clients.edit', item.id)"
                                                class=" cursor-pointer hover:text-blue-200 text-blue-400"><PencilSquare/>
                                            </a>
                                            <div @click="showConfirmDeleteModal = true; clientId = item.id"
                                                class="cursor-pointer hover:text-red-200 text-red-500"><Trash/>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-3 text-center">
                            Exibindo <span class="font-bold">{{clients.data.to}}</span> registros de um total de <span class="font-bold">{{clients.data.total}}</span>.
                        </div>
                        <div v-if="!shouldHidePagination">
                            <div class="m-5 flex flex-row flex-nowrap justify-between md:justify-center items-center"  aria-label="Pagination">
                                <div v-if="clients.data.prev_page_url" @click="showClients(clients.data.prev_page_url)" 
                                    class="cursor-pointer flex w-10 h-10 mx-1 justify-center items-center bg-white text-teal-400 hover:bg-teal-400 hover:text-white rounded-full border border-gray-200 hover:border-gray-300"
                                >
                                    <ArrowLongLeft></ArrowLongLeft>
                                </div>
                                <div 
                                v-for="link in cleanLinks" :key="link.label" 
                                @click="showClients(link.url)"
                                :class="{'bg-teal-400 text-white' : link.active, 'bg-white text-teal-400 hover:bg-teal-400 hover:text-white' : !link.active}"
                                class="cursor-pointer flex w-10 h-10 mx-1 justify-center items-center rounded-full border border-gray-200 hover:border-gray-300"
                                >
                                    {{ link.label }}
                                </div>
                                <div v-if="clients.data.next_page_url" @click="showClients(clients.data.next_page_url)" 
                                    class="cursor-pointer flex w-10 h-10 mx-1 justify-center items-center bg-white text-teal-400 hover:bg-teal-400 hover:text-white rounded-full border border-gray-200 hover:border-gray-300"
                                >
                                    <ArrowLongRight></ArrowLongRight>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div v-else class="mt-12 text-center">
                    {{ clients.message }}
                </div>
                <!-- Delete Token Confirmation Modal -->
                <ConfirmationModal :show="showConfirmDeleteModal" @close="showConfirmDeleteModal = false">
                    <template #title>
                        ATENÇÃO
                    </template>

                    <template #content>
                        Deseja realmente deletar esse registro?
                    </template>

                    <template #cancel>      
                        <PrimaryButton @click="showConfirmDeleteModal = false">
                            Não
                        </PrimaryButton>
                    </template>
                    <template #confirm>      
                        <PrimaryButton @click="deleteClient(clientId)">
                            Sim
                        </PrimaryButton>
                    </template>
                </ConfirmationModal>
            </div>
        </div>
    </AppLayout>
</template>

<style>
  html,
  body {
    height: 100%;
  }

  @media (min-width: 640px) {
    table {
      display: inline-table !important;
    }

    thead tr:not(:first-child) {
      display: none;
    }
  }

  td:not(:last-child) {
    border-bottom: 0;
  }

  th:not(:last-child) {
    border-bottom: 2px solid rgba(0, 0, 0, .1);
  }
</style>

