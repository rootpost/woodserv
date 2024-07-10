<template>
    <div class="container-xl">
        <div class="logo">
            <h1>ШИНОМОНТАЖ</h1>
            <hr>
        </div>
    <main class="main">
        <div class="left">
            <ul class="nav flex-column col-12">
                <li class="nav-item">
                    <router-link to="/invoices">
                        <!--<button class="btn btn-outline-primary rounded-0 mx-1">СЧЕТА</button>-->
                        <div class="my-nav text-primary">СЧЕТА</div>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/stocks">
                        <!--<button class="btn btn-outline-primary rounded-0 mx-1">ЗАПАСЫ/СКЛАД</button>-->
                        <div class="my-nav text-primary">ЗАПАСЫ/СКЛАД</div>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/customers">
                        <!--<button class="btn btn-outline-success rounded-0 mx-1">ЗАКАЗЧИКИ</button>-->
                        <div class="my-nav text-primary">ЗАКАЗЧИКИ</div>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/products">
                        <!--<button class="btn btn-outline-danger rounded-0 mx-1">ТОВАРЫ/УСЛУГИ</button>-->
                        <div class="my-nav text-primary">ТОВАРЫ/УСЛУГИ</div>
                    </router-link>
                </li>
            </ul>
        </div>
        <section class="center2">
            <router-view />
        </section>
    </main>
    </div>
</template>