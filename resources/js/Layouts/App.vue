<template>

  <div class="relative flex gap-3 justify-between bg-secundary">
    <div class=" w-[100%] md:w-[80%] 2xl:w-[80%]">
      <div class="p-[12px] md:h-[128vh] overflow-y-scroll scroll-zap">
        <slot />
      </div>
    </div>
    <SideBarRight v-if="$page.props.user?.name != null" class="w-[20%] hidden md:inline shadow-md 2xl:w-[15%] bg-white">
      <div class="bg-white w-full z-50 overflow-y-auto">
        <nav class="mt-6 list-none px-5">
          <div class="flex flex-col mt-4 text-center">
            <h1 class="font-semibold text-[14px] mb-1 text-[#000000]">{{ $page.props.user?.name }}</h1>
          </div>
          <div class="mt-[24px]">
            <h1 class="text-[20px] font-bold">Navegação</h1>
            <p class="font-bold text-[14px] text-[#858585]">Acesse as páginas para seu perfil</p>
          </div>
          <ul class="mt-[20px] flex flex-col gap-y-4">
            <Link as="button" :href="route('form.update.profile')">
            <li>

              <a class="px-3 py-5 bg-secundary flex items-center justify-between rounded-xl" href="#">
                <div class="flex gap-3 items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-6 h-6 text-primary">
                    <path fill-rule="evenodd"
                      d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                      clip-rule="evenodd" />
                  </svg>
                  <div>
                    <span class="font-bold text-[18px]">Meus dados</span>
                  </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                  <path fill-rule="evenodd"
                    d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z"
                    clip-rule="evenodd" />
                </svg>
              </a>

            </li>
            </Link>

            <li>
              <Link class="px-3 py-5 bg-secundary flex items-center justify-between rounded-xl" href="/logout"
                method="post">
              <div class="flex gap-3 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                  class="w-6 h-6 text-primary">
                  <path
                    d="M11.47 1.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1-1.06 1.06l-1.72-1.72V7.5h-1.5V4.06L9.53 5.78a.75.75 0 0 1-1.06-1.06l3-3ZM11.25 7.5V15a.75.75 0 0 0 1.5 0V7.5h3.75a3 3 0 0 1 3 3v9a3 3 0 0 1-3 3h-9a3 3 0 0 1-3-3v-9a3 3 0 0 1 3-3h3.75Z" />
                </svg>
                <div>
                  <span class="font-bold text-[18px]">Sair da conta</span>
                </div>
              </div>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd"
                  d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z"
                  clip-rule="evenodd" />
              </svg>
              </Link>
            </li>
          </ul>
        </nav>
      </div>
    </SideBarRight>
    <SideBarRight v-if="$page.props.user?.name == null" class="w-[20%] hidden md:inline shadow-md 2xl:w-[15%] bg-white">
      <div class="bg-white w-full z-50 overflow-y-auto">
        <nav class="mt-6 list-none px-5">
          <div class="flex flex-col mt-4 text-center">
            <h1 class="font-semibold text-[14px] mb-1 text-[#000000]">{{ $page.props.user?.name }}</h1>
          </div>
          <div class="mt-[24px]">
            <h1 class="text-[20px] font-bold">Navegação</h1>
            <p class="font-bold text-[14px] text-[#858585]">Acesse as páginas para seu perfil</p>
          </div>
          <ul class="mt-[20px] flex flex-col gap-y-4">
            <Link as="button" :href="route('form.store.user')">
            <li>

              <a class="px-3 py-5 bg-secundary flex items-center justify-between rounded-xl" href="#">
                <div class="flex gap-3 items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-6 h-6 text-primary">
                    <path fill-rule="evenodd"
                      d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                      clip-rule="evenodd" />
                  </svg>
                  <div>
                    <span class="font-bold text-[18px]">Fazer cadastro</span>
                  </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                  <path fill-rule="evenodd"
                    d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z"
                    clip-rule="evenodd" />
                </svg>
              </a>

            </li>
            </Link>
            <Link as="button" :href="route('login')">
            <li>

              <a class="px-3 py-5 bg-secundary flex items-center justify-between rounded-xl" href="#">
                <div class="flex gap-3 items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-6 h-6 text-primary">
                    <path fill-rule="evenodd"
                      d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                      clip-rule="evenodd" />
                  </svg>
                  <div>
                    <span class="font-bold text-[18px]">Fazer login</span>
                  </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                  <path fill-rule="evenodd"
                    d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z"
                    clip-rule="evenodd" />
                </svg>
              </a>

            </li>
            </Link>

          </ul>
        </nav>
      </div>
    </SideBarRight>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";

const toggleMenu = ref(false);
const toggleTextMenu = ref(false);


watch(toggleMenu, () => {
  if (!toggleMenu.value) {
    setTimeout(() => {
      toggleTextMenu.value = toggleMenu.value;
    }, 150);
    return;
  }
  toggleTextMenu.value = toggleMenu.value;
});
</script>


<style scoped>
* {
  scrollbar-width: auto;
  scrollbar-color: #d1d1d1 #ffffff;
}

*::-webkit-scrollbar {
  width: 12px;
}


*::-webkit-scrollbar-track {
  background: #ffffff;
}

*::-webkit-scrollbar-thumb {
  background-color: #d1d1d1;
  border-radius: 10px;
  border: 3px solid #ffffff;
}
</style>
