<script setup>
    import { onMounted, ref } from "vue"
    import { useRouter } from "vue-router"

    const router = useRouter()

    let form = ref([])

    onMounted(async () => {
        indexForm()
    })

    const indexForm = async () => {
        let response = await axios.get("/api/create_customer")
        //console.log('form', response.data)
        form.value = response.data
    }

    const onSave = () => {
            
        const formData = new FormData()
        formData.append('fl_name', form.value.fl_name)
        formData.append('full_name', form.value.full_name)
        formData.append('phone', form.value.phone)
        formData.append('address', form.value.address)
        formData.append('inn', form.value.inn)
        formData.append('kpp', form.value.kpp)
        formData.append('ogrn', form.value.ogrn)

        axios.post("/api/add_customer", formData)
        router.push('/customers')
    }

    const back = () => {
        router.push('/customers')
    }

</script>

<template>
<div class="container">
    <h2 class="invoice__title">НОВЫЙ ЗАКАЗЧИК</h2>
    <div class="blackline"></div>
    <div>
        <div>Краткое наименование организации</div>
        <input type="text" class="input" size="60" v-model="form.fl_name"><br>
        <div>Полное наименование организации</div>
        <input type="text" class="input" size="80" v-model="form.full_name"><br>
        <div>Телефон</div>
        <input type="text" class="input" v-model="form.phone"><br>
        <div>Юридический адрес организации</div>
        <input type="text" class="input" size="80" v-model="form.address"><br>
        <div>ИНН</div>
        <input type="text" class="input" v-model="form.inn"><br>
        <div>КПП</div>
        <input type="text" class="input" v-model="form.kpp"><br>
        <div>ОГРН</div>
        <input type="text" class="input" v-model="form.ogrn"><br>
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