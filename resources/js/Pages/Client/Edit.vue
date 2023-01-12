<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import JetFormSection from '@/Components/FormSectionTab.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';
import ButtonLink from '@/Components/ButtonLink.vue';
import ConfirmationModal from '@/Components/SuccessModal.vue';
import moment from 'moment';

const props = defineProps({
    id: String,
});

const form = useForm({
    name: '',
    cpf: '',
    birth_date: '',
    phone_number: '',
    errors: '',
    processing: false,
});

const showSuccessModal = ref(false);

const showClient = (url) => {
    return axios.get(url).then(response => {
        let birth_date = new Date(response.data.data.birth_date)
        form.name = response.data.data.name
        form.phone_number = response.data.data.phone_number
        form.cpf = response.data.data.cpf
        form.birth_date = moment(birth_date).format('YYYY-MM-DD');
    })
    .catch(function(error) {
        console.log(error)
    });
};

const onSubmit = () => {
    axios.put('/api/client/'+props.id, {
        name: form.name,
        cpf: form.cpf,
        birth_date: form.birth_date,
        phone_number: form.phone_number,
    }).then(() => {
        form.processing = false;
        showSuccessModal.value = true;
    }).catch(error => {
        form.processing = false;
        showSuccessModal.value = false;
        form.errors.name = error.response.data.data.errors.name ? error.response.data.data.errors.name[0] : '';
        form.errors.cpf = error.response.data.data.errors.cpf ? error.response.data.data.errors.cpf[0] : '';
        form.errors.birth_date = error.response.data.data.errors.birth_date ? error.response.data.data.errors.birth_date[0] : '';
    });
};

onMounted(() => {
    showClient('/api/client/'+props.id);
});

</script>

<template>
    <AppLayout title="Novo cliente">
        <template #header>
            Cadastrar novo cliente
        </template>
        <JetFormSection @submitted="onSubmit">
            <template #form>
                <div class="col-span">
                    <JetLabel for="name" value="Nome" />
                    <JetInput
                        required
                        id="name"
                        v-model="form.name"
                        type="text"
                    />
                    <JetInputError :message="form.errors.name" class="mt-2" />
                </div>
                <div class="col-span">
                    <JetLabel for="cpf" value="CPF" />
                    <JetInput
                        required
                        id="cpf"
                        v-model="form.cpf"
                        type="text"
                        v-mask="'###.###.###-##'"
                    />
                    <JetInputError :message="form.errors.cpf" class="mt-2" />
                </div>
                <div class="col-span">
                    <JetLabel for="birth_date" value="Data de nascimento" />
                    <JetInput
                        required
                        id="birth_date"
                        v-model="form.birth_date"
                        type="date"
                    />
                    <JetInputError :message="form.errors.birth_date" class="mt-2" />
                </div>
                <div class="col-span">
                    <JetLabel for="phone_number" value="Telefone (opcional)" />
                    <JetInput
                        id="phone_number"
                        v-model="form.phone_number"
                        type="text"
                        v-mask="['(##) #####-####', '(##) ####-####']"
                    />
                    <JetInputError :message="form.errors.phone_number" class="mt-2" />
                </div>
            </template>

            <template #actions>
                <ButtonLink :href="route('clients.list')">
                    Voltar
                </ButtonLink>
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Salvar
                </PrimaryButton>
            </template>
        </JetFormSection>
        <!-- Delete Token Confirmation Modal -->
        <ConfirmationModal :show="showSuccessModal" @close="showSuccessModal = false">
            <template #title>
                ATENÇÃO
            </template>

            <template #content>
                Registro salvo com sucesso!
            </template>

            <template #cancel>   
                <div></div>   
            </template>
            <template #confirm>      
                <PrimaryButton @click="showSuccessModal = false">
                    Confirmar
                </PrimaryButton>
            </template>
        </ConfirmationModal>
    </AppLayout>
</template>
