<script setup>
    import { onMounted, ref } from "vue"
    import { useRouter } from "vue-router"

    const router = useRouter()

    let form = ref({ id:'' })
    let allCustomers = ref([])
    let customer_id = ref([])
    const showModal = ref(false)
    const hideModal = ref(true)
    let listproducts = ref([])
    let listCart = ref([])

    const props = defineProps({
        id:{
            type:String,
            default:''
        }
    })

    onMounted(async () => {
        getInvoice()
        getAllCustomers()
        getProducts()
        //console.log(form)
    })

    const getInvoice = async () => {
        let response = await axios.get(`/api/edit_invoice/${props.id}`)
        console.log('form', response.data.invoice)
        //console.log('invoice_items_2', response.data.invoice_items_2)
        form.value = response.data.invoice
    }

    const getAllCustomers = async () => {
        let response = await axios.get("/api/customers")
        //console.log('response', response)
        allCustomers.value = response.data.customers
    }

    const openModal = () => {
        showModal.value = !showModal.value
    }

    const closeModal = () => {
        showModal.value = !hideModal.value
    }

    const getProduct = async (id) => {
        let response = await axios.get("/api/show_product/"+id)
        console.log('product', response)
        //listproducts.value = response.data.products
    }

    const getProducts = async () => {
        let response = await axios.get("/api/get_all_product")
        //console.log('products', response)
        listproducts.value = response.data.products
    }

    const addCart = (item) => {
        const itemcart = {
            product_id : item.id,
            item_code : item.item_code,
            item_name : item.item_name,
            quantity : 1,//item.quantity,
            price : item.price,
        }
        //listCart.value.push(itemcart)
        //console.log(form.value.invoice_items)
        form.value.invoice_items.push(itemcart)
        closeModal()
    }

    const deleteInvoiceItem = (id, i) => {
        form.value.invoice_items.splice(i,1)
        if(id != undefined){
            axios.get("/api/delete_invoice_items/"+id)
        }
    }
    
    const subTotal = () => {
        let total = 0
        if(form.value.invoice_items) {
            form.value.invoice_items.map((data)=>{
                total = total + (data.price*data.quantity)
            })
        }
        return total
    }
    
    const Total = () => {
        if(form.value.invoice_items) {
            return subTotal() - form.value.discount
        }
    }

    const back = () => {
        router.push('/invoices')
    }

    const onEdit = (id) => {
        if(form.value.invoice_items.length>=1) {
            console.log(JSON.stringify(form.value.invoice_items))
            
            let subtotal = 0
            subtotal = subTotal()

            let total = 0
            total = Total()

            const formData = new FormData()
            formData.append('invoice_items', JSON.stringify(form.value.invoice_items))
            formData.append('customer_id', form.value.customer_id)
            formData.append('date', form.value.date)
            formData.append('due_date', form.value.due_date)
            formData.append('number', form.value.number)
            formData.append('reference', form.value.reference)
            formData.append('sub_total', subtotal)
            formData.append('discount', form.value.discount)
            formData.append('total', total)
            formData.append('terms_and_conditions', form.value.terms_and_conditions)
            formData.append('status', "Новый")

            axios.post(`/api/update_invoice/${form.value.id}`, formData)
            form.value.invoice_items = []
            router.push('/invoices')
            
        }
    }

</script>
<template>
    <div class="container">
        <h2 class="invoice__title">РЕДАКТИРОВАНИЕ СЧЕТА № {{form.number}}</h2>
        <br>
        <div class="blackline"></div>
        <br>
        <div>
            <input type="text" class="input" v-model="form.number"> от
            <input id="date" placeholder="dd.mm.yyyy" type="date" class="input" v-model="form.date">
            <p class="my-1">Срок оплаты</p> 
            <input id="due_date" type="date" class="input" v-model="form.due_date">
        </div>
        <div style="margin-bottom: 4px;">
            <p class="my-1">Покупатель</p>
            <select name="" id="" class="input" v-model="form.customer_id">
                <option disabled>Выбрать покупателя</option>
                <option :value="customer.id" v-for="customer in allCustomers" :key="customer.id">
                    {{ customer.full_name }}
                </option>
            </select>
        </div>
        <table cellspacing="0" cellpadding="8" class="add_invoice">
            <thead>
                <tr>
                    <td>№</td>
                    <td>Наименование товара</td>
                    <td>Цена</td>
                    <td>Кол-во</td>
                    <td>Сумма</td>
                    <td>E</td>
                </tr>
            </thead>

            <tbody>
                <tr v-for="(itemcart, i) in form.invoice_items" :key="itemcart.id">
                    <td>{{i+1}}</td>
                    <!--<td>{{itemcart.product.item_code}}</td>
                    <td v-else>{{getProduct(itemcart.product_id)}}</td>-->
                    <td v-if="itemcart.product">{{itemcart.product.item_name}}</td>
                    <td v-else>{{itemcart.item_name}}</td>
                    <td>
                        <input type="text" style="width: 50px;" v-model="itemcart.price">
                    </td>
                    <td>
                        <input type="text" style="width: 31px;" v-model="itemcart.quantity">
                    </td>
                    <td>
                        <div v-if="itemcart.quantity">
                            {{ (itemcart.quantity) * (itemcart.price) }} р.
                        </div>
                        <div v-else></div>
                    </td>
                    <td style="color: red; font-size: 24px;cursor: pointer;" @click="deleteInvoiceItem(itemcart.id, i)">
                        &times;
                    </td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top:4px;">
            <button @click="openModal()">Добавить позицию</button>
        </div>

        <div class="invoice">
            <div class="invoice_left" >
                <div class="my-1">Дополнения</div>
                <textarea cols="40" rows="2" class="textarea" v-model="form.terms_and_conditions"></textarea>
                <div class="my-1">Примечание</div> 
                <input type="text" class="input" v-model="form.reference">
            </div>
            <div class="invoice_section">
                <b>Сумма</b><br>
                <span class="price_font">P {{subTotal()}}</span><br>
                <b>Скидка</b><br>
                <input type="text" size="8" class="input" v-model="form.discount"><br>
                <b>Всего</b><br>
                <span class="price_font">P {{Total()}}</span><br>
            </div>
        </div>

        <!--</div>-->
        <div>
            <a class="btn btn-secondary" @click="onEdit(form.id)">СОХРАНИТЬ</a>
            &nbsp;
            <a class="btn btn-secondary" @click="back()">ОТМЕНА</a>
        </div>
        <br>
        <div class="blackline"></div>
        <br>
        <!--==================== add modal items ====================-->
        <div class="modal main__modal " :class="{ show: showModal }">
            <div class="modal__content">
                <span class="modal__close btn__close--modal" @click="closeModal()">X</span>
                <h3 class="modal__title">Добавить товар</h3>
                <hr>
                <div class="modal__items">
                    <table>
                        <tr v-for="(item) in listproducts" :key="item.id">
                            <td>
                                <button @click="addCart(item)">+</button>
                                <span>{{ item.item_name }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
                <br><hr>
                <div class="model__footer">
                    <button class="btn btn-light mr-2 btn__close--modal" @click="closeModal()">
                        Отмена
                    </button>
                </div>
            </div>
        </div>
        <!--==================== add modal items ====================-->    
    </div>
</template>