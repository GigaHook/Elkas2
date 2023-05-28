<template>
	<v-col xl="3" md="4" sm="6" v-if="item.available == true">
		<v-hover v-slot="{ isHovering, props }">
			<v-card
				:elevation="isHovering ? 10 : 3"
				v-bind="props" 
				@click="router.get(`/${type}s/${item.id}`)"
				class="text-center px-3 pt-1 pb-3 card" 
				variant="plain"
			>
				<div class="text-h6">{{ item.name }}</div>
				<img :src="'../storage/' + item.image" class="w-100" style="aspect-ratio: 1 / 1;">
				<div class="my-3 text-h6">
					<span v-if="priceVariant">{{ item.price }}<Rub/></span>
					<span v-else>{{ item.count * item.price }}<Rub/>, по {{ item.price }}<Rub/> за шт</span>
				</div>
				<v-divider class="mb-3"/>
				<v-toolbar density="compact" color="#f9f7f7" rounded>
					<span class="text-subtitle me-auto px-auto ps-1">Кол-во: {{ item.count }}</span>
					<v-toolbar-items>
						<v-btn @click.stop="$emit('add', item.id, type)" icon="mdi-plus"/>
						<v-btn @click.stop="$emit('remove', item.id, type)" icon="mdi-minus"/>
						<v-btn @click.stop="$emit('delete', item.id, type)" icon="mdi-trash-can-outline"/>
					</v-toolbar-items>
				</v-toolbar>
			</v-card>
		</v-hover>
	</v-col>
</template>

<script>
export default {
  props: {
    item: Object,
		type: String,
		priceVariant: Boolean,
  },

  data() {
		return {
			
    }
  },
}
</script>

<script setup>
import { router } from '@inertiajs/vue3';
import Rub from '../Components/Rub.vue'
</script>

<style scoped>
.card{
	background-color: #f9f7f7;
	opacity: 1;
}
</style>