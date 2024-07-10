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
    })

    const getCustomer = async () => {
        let response = await axios.get(`/api/show_customer/${props.id}`)
        //console.log('form', response.data.customer)
        form.value = response.data.customer
    }
    
    const onEdit = (id) => {
        router.push('/customer/edit/'+id)
    }
    
    const deleteCustomer = (id) => {
        axios.get('/api/delete_product/'+id)
        router.push('/products')
    }

</script>

<template>
    <div class="container">
        <br>
        <div class="blackline"></div>
        <br>
        <div class="not_print">
            <a class="btn btn-secondary" onclick="window.history.back()">НАЗАД К СПИСКУ</a>&nbsp;
            <a class="btn btn-secondary" @click="onEdit(form.id)">ИЗМЕНИТЬ</a>&nbsp;
            <a class="btn btn-secondary" @click="deleteCustomer(form.id)">УДАЛИТЬ</a>
        </div>
        <br>
        <div class="blackline"></div>
        <br>
        <table class="product_table">
            <tr>
                <th>Краткое наименование организации</th>
                <td>{{form.fl_name}}</td>
            </tr>
            <tr>
                <th>Полное наименование организации</th>
                <td>{{form.full_name}}</td>
            </tr>
            <tr>
                <th>Адрес</th>
                <td>{{form.address}}</td>
            </tr>
            <tr>
                <th>Телефон</th>
                <td>{{form.phone}}</td>
            </tr>
            <tr>
                <th>ИНН/КПП</th>
                <td>{{form.inn}} / {{form.kpp}}</td>
            </tr>
            <tr>
                <th>ОГРН</th>
                <td>{{form.ogrn}}</td>
            </tr>
        </table>
        <br>
        <br>
        <div class="blackline"></div>
    </div>
</template>