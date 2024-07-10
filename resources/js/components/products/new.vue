<script setup>
    import { onMounted, ref } from "vue"
    import { useRouter } from "vue-router"

    const router = useRouter()

    let form = ref([])

    onMounted(async () => {
        indexForm()
    })

    const indexForm = async () => {
        let response = await axios.get("/api/create_product")
        console.log('form', response.data)
        form.value = response.data
    }

    const onSave = () => {
            
        const formData = new FormData()
        formData.append('item_code', form.value.item_code)
        formData.append('item_name', form.value.item_name)
        formData.append('description', form.value.description)
        formData.append('price', form.value.price)

        axios.post("/api/add_product", formData)
        router.push('/products')
        
    }

    const back = () => {
        router.push('/products')
    }

</script>

<template>
<div class="container">
    <h2 class="invoice__title">НОВЫЙ ТОВАР / УСЛУГА / РАБОТА</h2>
    <div class="blackline"></div>
    <div>
        <div>Артикул</div>
        <input type="text" class="input" v-model="form.item_code"><br>
        <div>Наименование товара/услуги/работы</div>
        <input type="text" size="80" class="input" v-model="form.item_name"><br>
        <div>Описание</div>
        <textarea cols="80" rows="2" class="textarea" v-model="form.description"></textarea><br>
        <div>Цена</div>
        <input type="text" class="input" v-model="form.price"><br>
    </div>
    <div class="blackline"></div>
    <div>
        <a class="btn btn-secondary" @click="onSave()">СОХРАНИТЬ</a>
        &nbsp;
        <a class="btn btn-secondary" @click="back()">ОТМЕНА</a>
    </div>
    <div class="blackline"></div>
</div>
</template>