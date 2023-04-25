<template>
  <v-app>

    <v-container style="height: 44px;">
      <v-app-bar class="justify-center" color="#DBE2EF" style="height: 44px;">
        <Link class="nav-item" href="/"><v-btn class="rounded-0 nav-item">Главная</v-btn></Link>
        <Link class="nav-item" href="/catalogue"><v-btn class="rounded-0 nav-item">Каталог</v-btn></Link>
        <Link class="nav-item"><v-btn class="rounded-0 nav-item">Услуги</v-btn></Link>
        <Link class="nav-item"><v-btn class="rounded-0 nav-item">О нас</v-btn></Link>
        <Link class="nav-item me-auto"><v-btn class="rounded-0 nav-item">Контакты</v-btn></Link>
        <Link class="nav-item cart-btn"><v-btn class="rounded-0 nav-item">крзн</v-btn></Link>
      </v-app-bar>
    </v-container>

    <v-row class="justify-center mt-4">
      <!--content-->
      <v-col xl="7" lg="8" md="8" sm="12">
        <v-card class="block py-1 px-3" elevation="3">
          <slot />
        </v-card>
      </v-col>
      
      <!--side-->
      <v-col xl="2" lg="3" md="4" sm="12">
        <!--auth-->
          <v-card v-if="!!user" class="block py-1 px-3" elevation="3">
            {{ user.name }} <br>
            <Link :href="route('logout')" method="post" as="button" preserve-state preserve-scroll><Button>Выйти</Button></Link>
          </v-card>
        <!--guest-->
        <div v-else>
          <v-card v-if="loginForm" class="block pa-3 text-center" elevation="3">
            
            <v-form @submit.prevent="loginSubmit" validate-on="blur" class="mb-3">
              <v-text-field
                type="email"
                v-model="email"
                :rules="[rules.required, rules.email]"
                label="E-mail"
                placeholder="example@gmail.com"
                color="#3F72AF"
                bg-color="#DBE2EF"
              />
              <v-text-field
                type="password"
                v-model="password"
                :rules="[rules.required, rules.range]"
                label="Пароль"
                hint="Минимум 8 символов"
                color="#3F72AF"
                bg-color="#DBE2EF"
              />
              <!--<v-btn type="submit" class="btn-var-1">Войти</v-btn>-->
              <Button type="submit">Войти</Button>
            </v-form>
            Нет аккаунта?
            <v-btn variant="tonal" @click="changeForm">Зарегистрироваться</v-btn>
          </v-card>

          <v-card v-else class="block pa-3 text-center" elevation="3">
            <v-form @submit.prevent="registerSubmit" validate-on="blur" class="mb-3">
              <v-text-field
                type="text"
                v-model="login"
                :rules="[rules.required, rules.range]"
                maxlength="20"
                label="Логин"
                placeholder="IvanovIvan"
                hint="От 8 до 20 символов"
                color="#3F72AF"
                bg-color="#DBE2EF"
              />
              <v-text-field
                type="email"
                v-model="email"
                :rules="[rules.required, rules.email]"
                label="E-mail"
                placeholder="example@gmail.com"
                color="#3F72AF"
                bg-color="#DBE2EF"
              />
              <v-text-field
                type="tel"
                v-model="number"
                :rules="[rules.required]"
                label="Телефон"
                placeholder="+71234567890"
                color="#3F72AF"
                bg-color="#DBE2EF"
              />
              <v-text-field
                type="password"
                v-model="password"
                :rules="[rules.required, rules.range]"
                maxlength="20"
                label="Пароль"
                hint="От 8 до 20 символов"
                color="#3F72AF"
                bg-color="#DBE2EF"
              />
            </v-form>
            Есть аккаунт? <br>
            <v-btn variant="tonal" @click="changeForm">Войти</v-btn>
          </v-card>
        </div>

      </v-col>
    </v-row>

  </v-app>
</template>

<script>
export default {

  data: () => ({
    email: '',
    password: '',
    login: '',
    number: '',
    rules: {
      required: value => !!value || "Это обязательное поле",
      email: value => (value.includes('@') && value.includes('.')) || "Неправильная почта",
      range: value => (value.length >= 8 && value.length <= 20) || "От 8 до 20 символов",
    },
    loginForm: true,
  }),


  methods: {
    loginSubmit() {
      router.post(route('login'), {
        email: this.email,
        password: this.password,
        remember: true
      }, {
        only: ['user'],
        preserveState: true,
        preserveScroll: true
      })
    },

    registerSubmit() {
      //TODO: register
    },

    changeForm() { 
      this.loginForm = !this.loginForm
    },

  }


}
</script>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import Button from '../Components/Button.vue'

defineProps({
  user: Object,
  status: String,
})

</script>

<style scoped>
.block {
  background-color: #f9f7f7;
}

.nav-item:hover {
  background-color: #3F72AF;
  color: #DBE2EF;
}

.nav-item {
  color: #112D4E;
  font-weight: 600;
  width: 100px;
  height: 100%;
  transition: all .1s ease-in-out;
}

.cart-btn {
  width: fit-content;
}

:deep(.v-btn--active > .v-btn__overlay) {
  /*magic 1*/
  opacity: 0;
}

:deep(.v-btn--active > .v-btn__underlay) {
  /*magic 2*/
  background-color: #F38307;
  z-index: -1;
}
</style>
