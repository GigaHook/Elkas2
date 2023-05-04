<template>
  <v-app>

    <v-container style="height: 44px;">
      <v-app-bar class="justify-center" color="#DBE2EF" style="height: 44px;" elevation="3">
        <Link class="nav-item" href="/"><v-btn class="rounded-0 nav-item">Главная</v-btn></Link>
        <Link class="nav-item" href="/products"><v-btn class="rounded-0 nav-item">Каталог</v-btn></Link>
        <Link class="nav-item" href="/services"><v-btn class="rounded-0 nav-item">Услуги</v-btn></Link>
        <Link class="nav-item"><v-btn class="rounded-0 nav-item">О нас</v-btn></Link>
        <Link class="nav-item me-auto"><v-btn class="rounded-0 nav-item">Контакты</v-btn></Link>

        <Link v-if="!!user" class="nav-item cart-btn" href="/cart">
          <v-btn class="rounded-0 nav-item cart-btn"><v-icon icon="mdi-cart-outline" size="30"/></v-btn>
        </Link>
        <span v-else class="cart-btn">
          <v-btn class="rounded-0 nav-item cart-btn" disabled><v-icon icon="mdi-cart-outline" size="30"/></v-btn>
        </span>

      </v-app-bar>
    </v-container>

    <v-row class="justify-center mt-3 mx-md-1 mx-lg-0">
      <!--content-->
      <v-col lg="8" md="9" sm="12">
        <slot/>
      </v-col>
      <!--side-->
      <v-col xl="2" lg="3" md="3" sm="12">
        <v-scroll-x-transition hide-on-leave>
          <!--auth-->
          <v-card v-if="!!user" class="pa-3" color="#f9f7f7" elevation="3">
            <span>Статус: <b>Авторизованный пользователь</b></span>
            <div class="d-flex flex-column">
              <v-icon icon="mdi-account-check-outline" size="100" class="align-self-center"/>
              <div class="text-h6 align-self-center mb-2">
                {{ user.name }}
              </div>
              Товаров в корзине: TODO <br>
              <Link class="align-self-center"><v-btn variant="tonal" append-icon="mdi-arrow-right" style="color:black" v-ripple="{ class: `text-info` }">В корзину</v-btn></Link>
              <Button @click="logout" class="mt-2 align-self-center">Выйти</Button>
            </div>
          </v-card>
          <!--guest-->
          <v-card v-else-if="formVariant" class="pa-3" color="#f9f7f7" elevation="3">
            <span>Статус: <b>Гость</b></span>
            <v-form @submit.prevent="loginSubmit" v-model="isLoginValid" validate-on="blur" class="text-center">
              <v-icon icon="mdi-account-remove-outline" style="transform: scaleX(-1);" size="100"/> <!--mirror magic-->
              <div class="text-h6 mb-3">Войдите в аккаунт</div>
              <v-text-field
                type="email"
                v-model="loginEmail"
                :rules="[rules.required, rules.email]"
                label="E-mail"
                placeholder="example@gmail.com"
                color="#3F72AF"
                bg-color="#DBE2EF"
                variant="solo"
                density="comfortable"
                required
              />
              <v-text-field
                type="password"
                v-model="loginPassword"
                :rules="[rules.required, rules.range]"
                label="Пароль"
                hint="От 8 до 20 символов"
                color="#3F72AF"
                bg-color="#DBE2EF"
                variant="solo"
                density="comfortable"
                required
              />
              <Button type="submit" class="mb-3">Войти</Button> <br>
              Нет аккаунта? <br>
              <v-btn 
                variant="text" 
                @click="formVariant = !formVariant" 
                append-icon="mdi-arrow-right" 
                v-ripple="{ class: `text-info` }"
                class="mt-1"
              >
                Зарегистрироваться
              </v-btn>
            </v-form>
          </v-card>
          <!--register-->
          <v-card v-else class="pa-3" color="#f9f7f7" elevation="3">
            <v-form @submit.prevent="registerSubmit" v-model="isRegisterValid" validate-on="blur" class="text-center">
              <div class="text-h6 mb-3">Регистрация</div>
              <v-text-field
                type="text"
                v-model="registerName"
                :rules="[rules.required, rules.range]"
                maxlength="20"
                label="Логин"
                placeholder="IvanovIvan"
                hint="От 8 до 20 символов"
                bg-color="#DBE2EF"
                color="#3F72AF"
                variant="solo"
                density="comfortable"
                required
              />
              <v-text-field
                type="email"
                v-model="registerEmail"
                :rules="[rules.required, rules.email]"
                label="E-mail"
                placeholder="example@gmail.com"
                bg-color="#DBE2EF"
                color="#3F72AF"
                variant="solo"
                density="comfortable"
                required
              />
              <v-text-field
                type="tel"
                v-model="registerNumber"
                :rules="[rules.required]"
                v-mask="[' (###) ###-##-##']"
                label="Телефон"
                placeholder="(555) 555-55-55"
                prefix="+7 "
                bg-color="#DBE2EF"
                color="#3F72AF"
                variant="solo"
                density="comfortable"
                required
              />
              <v-text-field
                type="password"
                v-model="registerPassword"
                :rules="[rules.required, rules.range]"
                maxlength="20"
                label="Пароль"
                hint="От 8 до 20 символов"
                bg-color="#DBE2EF"
                color="#3F72AF"
                variant="solo"
                density="comfortable"
                required
              />
              <v-text-field
                type="password"
                v-model="repeat"
                :rules="[rules.required, rules.repeat]"
                maxlength="20"
                label="Повторите пароль"
                hint="От 8 до 20 символов"
                bg-color="#DBE2EF"
                color="#3F72AF"
                variant="solo"
                density="comfortable"
                required
              />
              <Button type="submit" class="mb-3">Зарегистрироваться</Button> <br>
              Есть аккаунт? <br>
              <v-btn 
                variant="text" 
                @click="formVariant = !formVariant" 
                append-icon="mdi-arrow-right" 
                v-ripple="{ class: `text-info` }"
                class="mt-1"
              >
                Войти
              </v-btn>
            </v-form>
          </v-card>
        </v-scroll-x-transition>
      </v-col>
    </v-row>

    <v-snackbar 
      v-model="feedback" 
      timeout="3000"
      color="#f9f7f7"
      transition="scroll-y-reverse-transition"
    >
      <div style="color:black">
        <v-icon :color="feedbackColor" :icon="feedbackIcon" size="20"/>
        {{ feedbackText }}
      </div>
      <template v-slot:actions>
        <v-btn @click="feedback = false" variant="plain" color="black"><v-icon icon="mdi-close"/></v-btn>
      </template>
    </v-snackbar>

  </v-app>
</template>

<script>
export default {

  

  props: {
    user: Object,
  },

  data() {
    return {
      loginEmail: '',
      loginPassword: '',
      registerEmail: '',
      registerPassword: '',
      registerName: '',
      registerNumber: '',
      repeat: '',
      rules: {
        required: value => !!value || "Это обязательное поле",
        email: value => (value.includes('@') && value.includes('.')) || "Неправильная почта",
        range: value => (value.length >= 8 && value.length <= 20) || "От 8 до 20 символов",
        repeat: value => (value === this.registerPassword) || 'Пароли не совпадают'
      },
      formVariant: true,
      isLoginValid: true,
      isRegisterValid: true,
      //snackbar
      feedback: false,
      feedbackIcon: '',
      feedbackText: '',
      feedbackColor: '',
    }
  },

  methods: {
    clearForms() {
      this.loginEmail = ''
      this.loginPassword = ''
      this.registerEmail = ''
      this.registerPassword = ''
      this.registerName = ''
      this.registerNumber = ''
      this.repeat = ''
    },

    snackbar(text, icon='mdi-information-outline', color='info') {
      this.feedback = false
      this.feedbackText = text
      this.feedbackIcon = icon
      this.feedbackColor = color
      this.feedback = true
    },

    loginSubmit() {
      if (this.isLoginValid) {
        router.post(route('login'), {
          email: this.loginEmail,
          password: this.loginPassword,
          remember: true,
        }, {
          preserveState: true,
          preserveScroll: true,
          onSuccess: () => {
            this.snackbar('Вы вошли в аккаунт', 'mdi-account-check-outline', 'success')
            this.clearForms()
          },
          onError: () => {
            this.snackbar('Неверный логин или пароль', 'mdi-account-remove-outline', 'red-darken-2')
          }
        })
      }
    },

    registerSubmit() {
      if (this.isRegisterValid) {
        router.post(route('register'), {
          email: this.registerEmail,
          password: this.registerPassword,
          name: this.registerName,
          number: this.registerNumber,
        }, {
          preserveScroll: true,
          preserveState: true,
          onSuccess: () => {
            this.snackbar('Вы успешно зарагистрировались', 'mdi-account-plus-outline', 'success')
            this.clearForms()
          },
          onError: () => {
            this.snackbar('Ошибка. Проверьте ваши данные', 'mdi-account-remove-outline', 'red-darken-2')
          }
        })
      }
    },

    logout() {
      router.post(route('logout'), {
        preserveState: true,
        preserveScroll: true,
        onFinish: this.snackbar('Вы вышли из аккаунта')
      })
      
    },


  }


}
</script>

<script setup>
import { Link, Head, router } from '@inertiajs/vue3'
import Button from '../Components/Button.vue'

</script>

<style scoped>
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
</style>
