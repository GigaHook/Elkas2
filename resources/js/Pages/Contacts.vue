<template>
	<Head title="Контакты"/>
	<MainLayout :user="user">
		<v-card class="pa-3" elevation="3" color="#f9f7f7">
			<div class="text-h4 mb-3">
				Где нас найти
			</div>
			<v-row>

				<v-col cols="3">
					<div class="text-h6">
						Адрес
					</div>
					г. Канск <br>
					ул. Пролетарская <br>
					д. 34, офис 65
				</v-col>

				<v-col cols="3">
					<div class="text-h6">
						Почта
					</div>
					elkastest@gmail.com
				</v-col>

				<v-col cols="3">
					<div class="text-h6">
						Телефон
					</div>
					+7 (39161) 3-23-81 <br>
					+7 (39161) 6-35-00
				</v-col>

				<v-col cols="3">
					<div class="text-h6">
						График работы
					</div>
					Понедельник - Пятница <br>
					09:00 - 17:00
				</v-col>

			</v-row>
			<v-divider class="my-4"/>
			<div class="text-h4 mb-3">Мы на карте</div>
			<div class="w-100" ref="map" style="height: 480px;"></div>
		</v-card>
	</MainLayout>
</template>

<script>
export default {
	mounted() {
    ymaps.ready(() => new ymaps.Map(this.$refs['map'], {
        center: [56.204808, 95.713151], 
        zoom: 17
      }).geoObjects.add(new ymaps.Placemark([56.20456, 95.71314], {
				iconCaption: "Элкас",
				hintContent: "Мы здесь", 
				balloonContent: '<img src="storage/assets/contacts1.webp" width="280px">',
				balloonContentHeader: 'Вход'
			}))
    )
  }
}
</script>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
  user: Object,
})
</script>

<style scoped>

</style>