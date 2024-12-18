<template>
  <PageTitle title="Perfil" />

  <form @submit.prevent="submit">
    <section class="mt-6 bg-white rounded-sm p-10 shadow-sm" v-if="currentNav == 1">
      <div class="flex flex-col space-y-1">
        <SectionTitle class="text-xs text-gray-600 font-bold uppercase">INFORMAÇÕES GERAIS</SectionTitle>
        <SectionTitle class="text-xs text-gray-600">Informações essenciais para edição do usuário no sistema.
        </SectionTitle>
      </div>

      <div class="mt-10 grid grid-cols-2 gap-6 max-md:grid-cols-1">
        <span class="p-float-label">
          <InputText id="username" type="text" v-model="form.name" />
          <label for="username">Nome*</label>
        </span>
        <span class="p-float-label">
          <InputText id="username" type="email" v-model="form.email"
            :class="{ 'p-invalid': errorBags?.default?.email?.[0] }" disabled />
          <label for="username">E-mail *</label>
          <small id="username2-help" class="p-error">{{ errorBags?.default?.email?.[0] }}</small>
        </span>

        <div class="p-field p-col-12 p-md-4">
          <span class="p-float-label w-full">
            <Password v-model="form.password" autocomplete="off"
              :class="{ 'p-invalid': errorBags?.default?.password?.[0] }" class="w-full rounded-md" toggleMask>
              <template #footer="sp">
                {{ sp.level }}
                <Divider />
                <p class="mt-2">Sugestões</p>
                <ul class="pl-2 ml-2 mt-0 list-disc" style="line-height: 1.5">
                  <li>Ao menos uma letra minúscula</li>
                  <li>Ao menos uma letra maiúscula</li>
                  <li>Ao menos um número</li>
                  <li>8 caracteres, no mínimo.</li>
                </ul>
              </template>
            </Password>
            <label for="">Senha</label>
          </span>
          <small id="username2-help" class="p-error">{{ errorBags?.default?.password?.[0] }}</small>
        </div>

        <div class="p-field p-col-12 p-md-4">
          <span class="p-float-label w-full">

            <Password toggleMask class="w-full rounded-md" autocomplete="off" :feedback="false"
              v-model="form.password_confirmation"
              :class="{ 'p-invalid': errorBags?.default?.password_confirmation?.[0] }" />

            <label for="">Confirmação da Senha</label>
          </span>
          <small id="username2-help" class="p-error">{{ errorBags?.default?.password_confirmation?.[0] }}</small>
        </div>


      </div>
      <div class="flex space-x-5 mt-8">
        <button type="submit" :disabled="sending"
          class="p-2 flex rounded-md bg-primary text-white px-6 text-sm font-medium items-center"
          :class="{ 'bg-opacity-80 cursor-not-allowed': submited }">
          <svg role="status" v-show="submited" class="mr-2 w-4 h-4 animate-spin fill-primary" viewBox="0 0 100 101"
            fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
              fill="currentColor"></path>
            <path
              d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
              fill="currentFill"></path>
          </svg>
          Salvar
        </button>
      </div>
    </section>

  </form>
</template>

<script setup>
import moment from "moment";
import { ref, computed, defineProps } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import Password from "primevue/password";
import InputText from "primevue/inputtext";
import Dropdown from "primevue/dropdown";
import Permission from "../../Components/Permission.vue";
import MultiSelect from "primevue/multiselect";
import { useToast } from "vue-toastification";

const toast = useToast();


const currentNav = ref(1);

const props = defineProps({
  user: Object,
});

const errors = [{ Section1: {} }];
const statusOption = [
  { name: "Ativo", value: true },
  { name: "Inativo", value: false },
];

const submited = ref(false);

const form = useForm({
  user_id: props.user?.id,
  name: props.user?.name,
  email: props.user?.email,
  profile_picture: "",
  status: props.user?.status,
  link_group: props.user?.link_group,
  group_permissions: props.user?.roles?.at(-1)?.id,
  password: "",
  permission: getPermissionsArray(),
  password_confirmation: "",
  created_at: moment().format("D/MM/y H:m:s"),
});

function validateForm() {
  if (!form.name || !form.email) {
    throw toast.error(
      "Nome e E-mail não podem ser enviados em branco."
    );
  }
  if (form.password != form.password_confirmation) {
    throw toast.error(
      "As senhas não podem ser divergentes."
    );
  }

}

function getPermissionsArray() {
  return props.user?.permissions.map((val) => {
    return val?.id;
  });
}

function submit() {
  validateForm();
  submited.value = true;

  form.post(route("update.userProfile"), {
    preserveState: true,
    onError: () => {
      toast.error("Você não atendeu a todos os requisitos do formulário!");
    },
    onSuccess: () => {
      toast.success("Salvo com sucesso!");
    },
    onFinish: () => (submited.value = false),
  });
}

function attachAvatar(e) {
  form.profile_picture = e.target.files[0];
}
</script>



<style scoped>
.file-input {
  display: inline-block;
  text-align: left;
  background: #fff;
  width: 100%;
  position: relative;
  border-radius: 3px;
}

.file-input>[type="file"] {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  z-index: 10;
  cursor: pointer;
}

.file-input>.button {
  display: inline-block;
  cursor: pointer;
  background: #eee;
  padding: 8px 16px;
  border-radius: 2px;
  margin-right: 8px;
}

.file-input:hover>.button {
  background: #1f81a6;
  color: white;
  border-radius: 6px;
  transition: all 0.2s;
}

.file-input>.label {
  color: #333;
  white-space: nowrap;
  opacity: 0.3;
}

.file-input.-chosen>.label {
  opacity: 1;
}

/* Estilo geral para os campos de entrada */
.p-float-label input,
.p-float-label .p-inputtext,
.p-float-label .p-password-input,
.p-float-label .p-dropdown,
.p-float-label .p-multiselect {
  border-radius: 8px;
  /* Bordas arredondadas */
  border: 1px solid #d1d5db;
  /* Cor de borda padrão */
  padding: 8px;
  /* Espaçamento interno */
}

/* Ajustes específicos para MultiSelect */
.p-multiselect,
.p-multiselect-label-container {
  border-radius: 8px;
  border: 1px solid #d1d5db;
  padding: 8px;
}

/* Hover e Focus */
.p-float-label input:hover,
.p-float-label .p-inputtext:hover,
.p-float-label .p-password-input:hover,
.p-float-label .p-dropdown:hover,
.p-float-label .p-multiselect:hover,
.p-float-label input:focus,
.p-float-label .p-inputtext:focus,
.p-float-label .p-password-input:focus,
.p-float-label .p-dropdown:focus,
.p-float-label .p-multiselect:focus {
  border-color: #6b7280;
  /* Cor da borda ao passar o mouse ou focar */
  outline: none;
}

/* Estilo específico para Dropdown e MultiSelect */
.p-dropdown,
.p-multiselect {
  width: 100%;
  border-radius: 8px;
  border: 1px solid #d1d5db;
  padding: 8px;
  background-color: white;
}

/* Estilo do botão de envio */
button[type="submit"] {
  border-radius: 8px;
  transition: background-color 0.2s ease;
}

button[type="submit"]:hover {
  background-color: #4b5563;
}

/* Estilo da caixa de upload de arquivo */
.file-input {
  border-radius: 8px;
  border: 1px solid #d1d5db;
}

.file-input input {
  display: none;
}

.file-input .button {
  cursor: pointer;
}



/* Estilo para garantir que o texto não seja cortado */
.p-multiselect-label-container,
.p-multiselect,
.p-dropdown,
.p-float-label .p-inputtext,
.p-float-label .p-password-input {
  line-height: 1.0;
  /* Ajusta a altura da linha */
  overflow: visible;
  /* Garante que o conteúdo não seja cortado */
}

/* Ajuste específico para o MultiSelect para evitar corte */
.p-multiselect-label-container {
  display: flex;
  align-items: center;
  /* Centraliza o texto verticalmente */
  height: 50%;
  /* Ajusta a altura */
}
</style>