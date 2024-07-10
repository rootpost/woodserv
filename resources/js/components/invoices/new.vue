<script setup>
    import { onMounted, ref } from "vue"
    import { useRouter } from "vue-router"

    const router = useRouter()

    let form = ref([])
    let allCustomers = ref([])
    let customer_id = ref([])
    let item = ref([])
    let listCart = ref([])
    const showModal = ref(false)
    const hideModal = ref(true)
    let listproducts = ref([])

    onMounted(async () => {
        indexForm()
        getAllCustomers()
        getProducts()
    })

    const indexForm = async () => {
        let response = await axios.get("/api/create_invoice")
        //console.log('form', response.data)
        form.value = response.data
    }

    const getAllCustomers = async () => {
        let response = await axios.get("/api/customers")
        //console.log('response', response)
        allCustomers.value = response.data.customers
    }

    const addCart = (item) => {
        const itemcart = {
            id : item.id,
            item_code : item.item_code,
            item_name : item.item_name,
            quantity : 1,//item.quantity,
            price : item.price,
        }
        listCart.value.push(itemcart)
        closeModal()
    }

    const removeItem = (i) => {
        listCart.value.splice(i,1)
    }

    const openModal = () => {
        showModal.value = !showModal.value
    }

    const closeModal = () => {
        showModal.value = !hideModal.value
    }

    const getProducts = async () => {
        let response = await axios.get("/api/get_all_product")
        //console.log('products', response)
        listproducts.value = response.data.products
    }

    const subTotal = () => {
        let total = 0
        listCart.value.map((data)=>{
            total = total + (data.price*data.quantity)
        })
        return total
    }

    const Total = () => {
        return subTotal() - form.value.discount
    }

    const onSave = () => {
        if(listCart.value.length>=1){
            let subtotal = 0
            subtotal = subTotal()

            let total = 0
            total = Total()

            const formData = new FormData()
            formData.append('invoice_item', JSON.stringify(listCart.value))
            formData.append('customer_id', customer_id.value)
            formData.append('date', form.value.date)
            formData.append('due_date', form.value.due_date)
            formData.append('number', form.value.number)
            formData.append('reference', form.value.reference)
            formData.append('sub_total', subtotal)
            formData.append('discount', form.value.discount)
            formData.append('total', total)
            formData.append('terms_and_conditions', form.value.terms_and_conditions)
            formData.append('status', "Новый")

            axios.post("/api/add_invoice", formData)
            listCart.value = []
            router.push('/invoices')
        }
    }
    
    const back = () => {
        router.push('/invoices')
    }
</script>

<template>
<div class="container">
        <h2 class="invoice__title">НОВЫЙ СЧЕТ</h2>
        <div class="blackline"></div>
        <!--
        <div class="card__content">
            <div class="card__content--header">
        -->

                <div>
                    <b>№</b>&nbsp;<input type="text" size="5" class="input" v-model="form.number"> <b>от</b>&nbsp;
                    <input id="date" placeholder="dd.mm.yyyy" type="date" class="input" v-model="form.date">
                    <p class="my-1">Срок оплаты</p> 
                    <input id="due_date" type="date" class="input" v-model="form.due_date">
                    
                </div>
                <div> 
                    <!--
                    <p class="my-1">Срок оплаты</p> 
                    <input id="due_date" type="date" class="input" v-model="form.due_date">
                    -->
                </div>
                <div style="margin-bottom: 4px;">
                    <p class="my-1">Покупатель</p>
                    <select name="customer" style="padding: 4px;font-size:13pt;" class="input" v-model="customer_id">
                        <option disabled>Выбрать покупателя</option>
                        <option :value="customer.id" v-for="customer in allCustomers" :key="customer.id">
                            {{ customer.full_name }}
                        </option>
                    </select>
                </div>
            <!--</div>-->
            <div class="blackline"></div>
            <table cellspacing="0" cellpadding="8" class="add_invoice">
                <thead>
                    <tr>
                        <td>№</td>
                        <td>Код</td>
                        <td>Наименование товара</td>
                        <td>Цена</td>
                        <td>Кол-во</td>
                        <td>Сумма</td>
                        <td>E</td>
                    </tr>
                </thead>
    
                <tbody>
                    <tr v-for="(itemcart, i) in listCart" :key="itemcart.id">
                        <td>{{i+1}}</td>
                        <td>{{itemcart.item_code}}</td>
                        <td>{{itemcart.item_name}}</td>
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
                        <td style="color: red; font-size: 24px;cursor: pointer;" @click="removeItem(i)">
                            &times;
                        </td>
                    </tr>
                </tbody>
            </table>
            <div style="margin-top:4px;">
                <button @click="openModal()">Добавить позицию</button>
            </div>
            <div class="blackline"></div>
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
            <div class="blackline"></div>
        <!--</div>-->
            <div>
                <a class="btn btn-secondary" @click="onSave()">
                    СОХРАНИТЬ
                </a>&nbsp;
                <a class="btn btn-secondary" @click="back()">
                    ОТМЕНА
                </a>
            </div>
            <div class="blackline"></div>
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
                            
                            
                        </td>
                        <td><div>{{ item.item_name }}</div></td>
                        <td width="80"><b>{{ item.price }} р.</b></td>
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