<template>
  <v-app>

    <v-container style="height: 44px;">
      <v-app-bar class="justify-center" color="#DBE2EF" style="height: 44px;" elevation="3">
        <Link class="nav-item" href="/"><v-btn class="rounded-0 nav-item">Главная</v-btn></Link>
        <Link class="nav-item" href="/catalogue"><v-btn class="rounded-0 nav-item">Каталог</v-btn></Link>
        <Link class="nav-item"><v-btn class="rounded-0 nav-item">Услуги</v-btn></Link>
        <Link class="nav-item"><v-btn class="rounded-0 nav-item">О нас</v-btn></Link>
        <Link class="nav-item me-auto"><v-btn class="rounded-0 nav-item">Контакты</v-btn></Link>
        <Link class="nav-item cart-btn"><v-btn class="rounded-0 nav-item">крзн</v-btn></Link>
      </v-app-bar>
    </v-container>

    <v-row class="justify-center mt-3">
      <!--content-->
      <v-col xl="7" lg="8" md="8" sm="12">
        <v-card class="block py-1 px-3" elevation="3">
          <slot/>          
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
        <v-slide-x-transition v-else hide-on-leave>
          <!--login-->
          <v-card v-if="loginVariant" class="block pa-3" elevation="3">
            <span>Статус: <b>Гость</b></span>
            <v-form @submit.prevent="loginSubmit" v-model="isLoginValid" validate-on="blur" class="text-center">
              <v-icon icon="mdi-account-remove-outline" style="transform: scaleX(-1);" size="120"/> <!--mirror magic-->
              <div class="text-h6 mb-3">Войдите в аккаунт</div>
              <v-text-field
                type="email"
                v-model="email"
                :rules="[rules.required, rules.email]"
                label="E-mail"
                placeholder="example@gmail.com"
                color="#3F72AF"
                bg-color="#DBE2EF"
                variant="solo"
                required
              />
              <v-text-field
                type="password"
                v-model="password"
                :rules="[rules.required, rules.range]"
                label="Пароль"
                hint="Минимум 8 символов"
                color="#3F72AF"
                bg-color="#DBE2EF"
                variant="solo"
                required
              />
              <!--<v-btn type="submit" class="btn-var-1">Войти</v-btn>-->
              <Button type="submit" class="mb-3">Войти</Button> <br>
              Нет аккаунта? <br>
              <v-btn 
                variant="tonal" 
                @click="loginVariant = !loginVariant" 
                append-icon="mdi-arrow-right" 
                v-ripple="{ class: `text-info` }"
                class="mt-1"
              >
                Зарегистрироваться
              </v-btn>
            </v-form>
          </v-card>
          <!--register-->
          <v-card v-else class="block pa-3" elevation="3">
            <v-form @submit.prevent="registerSubmit" v-model="isRegisterValid" validate-on="blur" class="text-center">
              <div class="text-h6 mb-3">Регистрация</div>
              <v-text-field
                type="text"
                v-model="name"
                :rules="[rules.required, rules.range]"
                maxlength="20"
                label="Логин"
                placeholder="IvanovIvan"
                hint="От 8 до 20 символов"
                bg-color="#DBE2EF"
                color="#3F72AF"
                variant="solo"
              />
              <v-text-field
                type="email"
                v-model="email"
                :rules="[rules.required, rules.email]"
                label="E-mail"
                placeholder="example@gmail.com"
                bg-color="#DBE2EF"
                color="#3F72AF"
                variant="solo"
                solo
              />
              <v-text-field
                type="tel"
                v-model="number"
                :rules="[rules.required]"
                v-mask="[' (###) ###-##-##']"
                label="Телефон"
                placeholder="(555) 555-55-55"
                prefix="+7 "
                bg-color="#DBE2EF"
                color="#3F72AF"
                variant="solo"
              />
              <v-text-field
                type="password"
                v-model="password"
                :rules="[rules.required, rules.range]"
                maxlength="20"
                label="Пароль"
                hint="От 8 до 20 символов"
                bg-color="#DBE2EF"
                color="#3F72AF"
                variant="solo"
              />
              <v-text-field
                type="password"
                v-model="repeat"
                :rules="[rules.required, repeatRule]"
                maxlength="20"
                label="Повторите пароль"
                hint="От 8 до 20 символов"
                bg-color="#DBE2EF"
                color="#3F72AF"
                variant="solo"
              />
              <Button type="submit" class="mb-3">Зарегистрироваться</Button> <br>
              Есть аккаунт? <br>
              <v-btn 
                variant="tonal" 
                @click="loginVariant = !loginVariant" 
                append-icon="mdi-arrow-right" 
                v-ripple="{ class: `text-info` }"
                class="mt-1"
              >
                Войти
              </v-btn>
            </v-form>
          </v-card>
        </v-slide-x-transition>

      </v-col>
    </v-row>

  </v-app>
</template>

<script>
export default {

  data: () => ({
    email: '',
    password: '',
    name: '',
    number: '',
    repeat: '',
    rules: {
      required: value => !!value || "Это обязательное поле",
      email: value => (value.includes('@') && value.includes('.')) || "Неправильная почта",
      range: value => (value.length >= 8 && value.length <= 20) || "От 8 до 20 символов"
    },
    loginVariant: true,
    isLoginValid: true,
    isRegisterValid: true,
  }),


  methods: {
    repeatRule(value) {
      return (value === this.password) || 'Пароли не совпадают'
    },

    clearForms() {
      this.email = ''
      this.password = ''
      this.name = ''
      this.number = ''
    },

    loginSubmit() {
      if (this.isLoginValid) {
        router.post(route('login'), {
          email: this.email,
          password: this.password,
          remember: true
        }, {
          only: ['user'],
          preserveState: true,
          preserveScroll: true
        })
      }
    },

    registerSubmit() {
      if (this.isRegisterValid) {
        router.post(route('register'), {
          email: this.email,
          password: this.password,
          name: this.name,
          number: this.number,
        }, {
          only: ['user'],
          preserveScroll: true,
          preserveState: true
        })
      }
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
