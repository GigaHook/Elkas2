<template>
	<v-col xl="3" md="4" sm="6" v-if="item.available == true">
		<v-hover v-slot="{ isHovering, props }">
			<v-card
				:elevation="isHovering ? 10 : 3"
				v-bind="props" 
				@click="router.get('/' + type + '/' + item.id)"
				class="text-center px-3 pt-1 pb-3 card" 
				variant="plain"
			>
				<div class="text-h6">{{ item.name }}</div>
				<v-sheet class="my-1 w-100 img" style="aspect-ratio: 1 / 1;">img</v-sheet>
				<div v-if="item.count == 1" class="my-3 text-subtitle-1">
					${{ item.price }}
				</div>
				<div v-else class="my-3 text-subtitle-1">
					${{ item.count * item.price }}, по ${{ item.price }} за шт
				</div>
				<v-divider class="mb-3"/>
				<v-toolbar density="compact" color="#f9f7f7" rounded>
					<span class="text-subtitle me-auto px-auto ps-1">
						Кол-во: {{ item.count }}
					</span>
					<v-toolbar-items>
						<v-btn icon="mdi-plus"/>
						<v-btn icon="mdi-minus"/>
						<v-btn
							@click.stop="router.delete(`/cart/product/${item.id}`, { id: item.id })" 
							icon="mdi-trash-can-outline" 
							color="error"
						/>
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
  },

	methods: {
		
	},

  data() {
		return {
			
    }
  },
}
</script>

<script setup>
import { router } from '@inertiajs/vue3'
</script>

<style scoped>
.card{
	background-color: #f9f7f7;
	opacity: 1;
}
</style>