<template>
    <div class="container">
        <div class="mx-auto" style="height: 50px;"></div>
        <div class="row">
            <div class="col-lg-4">
                <h2>Edit Inventory</h2>
                <form>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input v-model="name" type="text" class="form-control" id="name" aria-describedby="name" placeholder="Update your name">
                    </div>
                    <div class="form-group">
                        <label for="name">Quantity</label>
                        <input v-model="quantity" type="number" class="form-control" id="quantity" aria-describedby="quantity" placeholder="Quantity">
                    </div>
                    <div class="form-group">
                        <label for="region">Region</label>
                        <input v-model="region" type="text" class="form-control" id="region" aria-describedby="region" placeholder="Region">
                    </div>
                    <div class="form-group">
                        <label for="image" class="d-block">Image</label>
                        <input @change="onImageChange" type="file" id="image" placeholder="Insert item image." accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select v-model="category" class="form-control" id="category">
                            <option v-for="category in categories" :value="category">{{ category.name }}</option>
                        </select>
                        <div v-if="category !== null">{{ category.description }}</div>
                    </div>
                    <div v-if="category !== null" class="form-group">
                        <label for="subcategory">Sub Category</label>
                        <select v-model="subcategory" class="form-control" id="subcategory">
                            <option v-for="subcategory in subcategories" :value="subcategory">{{ subcategory.name }}</option>
                        </select>
                        <div v-if="subcategory !== null">{{ subcategory.description }}</div>
                    </div>
                    <button @click.prevent="update" type="submit" class="btn btn-primary btn-block">Update</button>
                </form>
            </div>
            <div class="col-lg-8">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-5">
                                <h2>Borrower <b>Management</b></h2>
                            </div>
                            <div class="col-sm-7">
                                <a href="#" class="btn btn-primary"><i class="material-icons">&#xE147;</i> <span>Add New User</span></a>
                                <a href="#" class="btn btn-primary"><i class="material-icons">&#xE24D;</i> <span>Export to Excel</span></a>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(borrower, index) in borrowers">
                            <td>{{ ++index }}</td>
                            <td><a href="#">{{ borrower.user.name }}</a></td>
                            <td>{{ borrower.updated_at }}</td>
                            <td>{{ borrower.quantity }}</td>
                            <td v-if="borrower.returned"><span class="status text-success">&bull;</span> Returned <a href="#" @click.prevent="toggleReturn(borrower.id, index)"><i style="font-size: 14px;" class="fas fa-exchange-alt"></i></a></td>
                            <td v-else><span class="status text-danger">&bull;</span> Borrowing <a href="#" @click.prevent="toggleReturn(borrower.id, index)"><i style="font-size: 14px;" class="fas fa-exchange-alt"></i></a></td>
                            <td>
                                <!--<a href="#" class="settings" title="Settings" data-toggle="tooltip"><i class="material-icons">&#xE8B8;</i></a>-->
                                <a @click.prevent="destroyBorrower(borrower.id, index)" href="#" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE5C9;</i></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="clearfix">
                        <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                        <ul class="pagination">
                            <li class="page-item disabled"><a href="#">Previous</a></li>
                            <li class="page-item"><a href="#" class="page-link">1</a></li>
                            <li class="page-item"><a href="#" class="page-link">2</a></li>
                            <li class="page-item active"><a href="#" class="page-link">3</a></li>
                            <li class="page-item"><a href="#" class="page-link">4</a></li>
                            <li class="page-item"><a href="#" class="page-link">5</a></li>
                            <li class="page-item"><a href="#" class="page-link">Next</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    body {
        color: #566787;
        background: #f5f5f5;
        font-family: 'Varela Round', sans-serif;
        font-size: 13px;
    }
    .table-wrapper {
        background: #fff;
        padding: 20px 25px;
        margin: 30px 0;
        border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .table-title {
        padding-bottom: 15px;
        background: #299be4;
        color: #fff;
        padding: 16px 30px;
        margin: -20px -25px 10px;
        border-radius: 3px 3px 0 0;
    }
    .table-title h2 {
        margin: 5px 0 0;
        font-size: 24px;
    }
    .table-title .btn {
        color: #566787;
        float: right;
        font-size: 13px;
        background: #fff;
        border: none;
        min-width: 50px;
        border-radius: 2px;
        border: none;
        outline: none !important;
        margin-left: 10px;
    }
    .table-title .btn:hover, .table-title .btn:focus {
        color: #566787;
        background: #f2f2f2;
    }
    .table-title .btn i {
        float: left;
        font-size: 21px;
        margin-right: 5px;
    }
    .table-title .btn span {
        float: left;
        margin-top: 2px;
    }
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
        padding: 12px 15px;
        vertical-align: middle;
    }
    table.table tr th:first-child {
        width: 60px;
    }
    table.table tr th:last-child {
        width: 100px;
    }
    table.table-striped tbody tr:nth-of-type(odd) {
        background-color: #fcfcfc;
    }
    table.table-striped.table-hover tbody tr:hover {
        background: #f5f5f5;
    }
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }
    table.table td:last-child i {
        opacity: 0.9;
        font-size: 22px;
        margin: 0 5px;
    }
    table.table td a {
        font-weight: bold;
        color: #566787;
        display: inline-block;
        text-decoration: none;
    }
    table.table td a:hover {
        color: #2196F3;
    }
    table.table td a.settings {
        color: #2196F3;
    }
    table.table td a.delete {
        color: #F44336;
    }
    table.table td i {
        font-size: 19px;
    }
    table.table .avatar {
        border-radius: 50%;
        vertical-align: middle;
        margin-right: 10px;
    }
    .status {
        font-size: 30px;
        margin: 2px 2px 0 0;
        display: inline-block;
        vertical-align: middle;
        line-height: 10px;
    }
    .text-success {
        color: #10c469;
    }
    .text-info {
        color: #62c9e8;
    }
    .text-warning {
        color: #FFC107;
    }
    .text-danger {
        color: #ff5b5b;
    }
    .pagination {
        float: right;
        margin: 0 0 5px;
    }
    .pagination li a {
        border: none;
        font-size: 13px;
        min-width: 30px;
        min-height: 30px;
        color: #999;
        margin: 0 2px;
        line-height: 30px;
        border-radius: 2px !important;
        text-align: center;
        padding: 0 6px;
    }
    .pagination li a:hover {
        color: #666;
    }
    .pagination li.active a, .pagination li.active a.page-link {
        background: #03A9F4;
    }
    .pagination li.active a:hover {
        background: #0397d6;
    }
    .pagination li.disabled i {
        color: #ccc;
    }
    .pagination li i {
        font-size: 16px;
        padding-top: 6px
    }
    .hint-text {
        float: left;
        margin-top: 10px;
        font-size: 13px;
    }
</style>

<script>
    export default {
        data() {
            return {
                name: '',
                quantity: 0,
                region: '',
                image: '',
                categories: [],
                category: [],
                subcategory: [],
                subcategories: [],
                borrowers: []
            }
        },
        methods: {
            getCategories() {
                axios.get('/categories')
                    .then(res => {
                        this.categories = res.data.data
                    })
                    .catch(err => {
                        // use sweetalert
                    })
            },
            getInventory() {
                axios.get(`/inventory/${this.$route.params.id}`)
                    .then(res => {
                        this.name = res.data.data.name
                        this.quantity = res.data.data.quantity
                        this.region = res.data.data.region
                        this.image = res.data.data.image
                        this.category = res.data.data.category
                        this.subcategory = res.data.data.category.sub_category
                        this.subcategories = res.data.categories
                    })
                    .catch(err => {
                        this.$swal({
                            type: 'error',
                            title: 'Sorry, we are unable to fetch the inventory data.',
                            text: 'It looks like that is some errors going on. Please contact your adminstrator.'
                        })
                    })
            },
            onImageChange(event) {
                this.image = event.target.files[0]
            },
            getBorrower() {
                axios.get(`/borrower/${this.$route.params.id}`)
                    .then(res => {
                        this.borrowers = res.data.data
                    })
                    .catch(err => {
                        this.$swal({
                            type: 'error',
                            title: 'Oh, we caught an error!',
                            text: 'Please contact your adminstrator to resolve this problem.'
                        })
                    })
            },
            toggleReturn(id, index) {
                axios.put(`/borrower/${id}`)
                    .then(res => {
                        this.borrowers[--index].returned =! this.borrowers[index].returned
                        this.borrowers[index].updated_at = res.data.data.updated_at
                    })
                    .catch(err => {
                        this.$swal({
                            type: 'error',
                            title: 'We caught an error!',
                            text: 'Please contact your system adminstrator to resolve this error.'
                        })
                    })
            },
            destroyBorrower(id, index) {
                axios.delete(`/borrower/${id}`)
                    .then(res => {
                        this.borrowers.splice(--index,1)
                        this.$swal({
                            type: 'success',
                            title: 'Successfully remove borrower record!',
                            text: "You can't undo this action!"
                        })
                    })
                    .catch(err => {
                        this.$swal({
                            type: 'error',
                            title: 'We caught an error!',
                            text: 'Please contact your system adminstrator to resolve this error.'
                        })
                    })
            },
            update() {
                let formData = new FormData()
                formData.append('name', this.name)
                // formData.append('image', this.image)
                formData.append('category_id', this.category.id)
                formData.append('quantity', this.quantity)
                formData.append('region', this.region)
                formData.append('inventory_id', this.$route.params.id)

                axios.post('/inventory', formData)
                    .then(res => {
                        this.name = res.data.data.name
                        this.quantity = res.data.data.quantity
                        this.region = res.data.data.region
                        this.image = res.data.data.image
                        this.category = res.data.data.category
                        this.$swal({
                            type: 'success',
                            title: 'Successfully updated record!'
                        })
                    })
                    .catch(err => {
                        this.$swal({
                            type: 'error',
                            title: 'We caught an error!',
                            text: 'Please contact your system adminstrator to resolve this error.'
                        })
                    })
            }
        },
        mounted() {
            this.getCategories()
            this.getInventory()
            this.getBorrower()
        }
    }
</script>