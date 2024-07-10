<script setup>
    import { onMounted, ref } from "vue"
    import { useRouter } from "vue-router"

    const router = useRouter()

    let form = ref({ id:'' })

    const props = defineProps({
        id:{
            type:String,
            default:''
        }
    })

    onMounted(async () => {
        getCustomer()
        //getAllCustomers()
        //console.log(form)
    })

    const getCustomer = async () => {
        let response = await axios.get(`/api/edit_customer/${props.id}`)
        console.log('form', response.data.customer)
        form.value = response.data.customer
    }

    const back = () => {
        router.push('/customers')
    }

    const onEdit = (id) => {
        //console.log(JSON.stringify(form.value.invoice_items))
        
        const formData = new FormData()
        formData.append('fl_name', form.value.fl_name)
        formData.append('full_name', form.value.full_name)
        formData.append('address', form.value.address)
        formData.append('phone', form.value.phone)
        formData.append('inn', form.value.inn)
        formData.append('kpp', form.value.kpp)
        formData.append('ogrn', form.value.ogrn)

        axios.post(`/api/update_customer/${form.value.id}`, formData)
        
        router.push('/customers')
    }

</script>
<template>
    <div class="container">
        <h2 class="invoice__title">РЕДАКТИРОВАНИЕ {{form.fl_name}}</h2>
        <br>
        <div class="blackline"></div>
        <br>
        <div class="not_print">
            <a class="btn btn-secondary" onclick="window.history.back()">НАЗАД К СПИСКУ</a>&nbsp;
        </div>
        <br>
        <div class="blackline"></div>
        <br>
        <table class="product_table">
            <tr>
                <th>Краткое наименование организации</th>
                <td><input type="text" size="20" v-model="form.fl_name"></td>
            </tr>
            <tr>
                <th>Полное наименование организации</th>
                <td><input type="text" size="50" v-model="form.full_name"></td>
            </tr>
            <tr>
                <th>Адрес</th>
                <td><input type="text" size="50" v-model="form.address"></td>
            </tr>
            <tr>
                <th>Телефон</th>
                <td><input type="text" size="8" v-model="form.phone"></td>
            </tr>
            <tr>
                <th>ИНН/КПП</th>
                <td><input type="text" size="8" v-model="form.inn"> / <input type="text" size="8" v-model="form.kpp"></td>
            </tr>
            <tr>
                <th>ОГРН</th>
                <td><input type="text" size="8" v-model="form.ogrn"></td>
            </tr>
        </table>
        <br>
        <!--</div>-->
        <div>
            <a class="btn btn-secondary" @click="onEdit(form.id)">СОХРАНИТЬ</a>
            &nbsp;
            <a class="btn btn-secondary" @click="back()">ОТМЕНА</a>
        </div>
        <br>
        <div class="blackline"></div>
        <br>
    </div>
</template>