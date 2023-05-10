<template>
	<Head title="Контакты"/>
	<MainLayout :user="user">
		<v-card class="pa-3" elevation="3" color="#f9f7f7">
			<div ref="map" style="height: 500px; width: 100%;"></div>
		</v-card>
	</MainLayout>
</template>

<script>
export default {
	mounted() {
    ymaps.ready(() => new ymaps.Map(this.$refs['map'], {
        center: [56.204808, 95.713151], 
        zoom: 17
      }).geoObjects.add(new ymaps.Placemark([56.204808, 95.713151], {
				hintContent: "Элкас", 
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