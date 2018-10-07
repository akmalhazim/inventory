<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="mx-auto" style="height: 50px;"></div>
                <form @submit.prevent="save">
                    <div class="form-group">
                        <label for="itemName">Item Name</label>
                        <input v-model="name" type="text" class="form-control" id="itemName" placeholder="Item name">
                    </div>
                    <div class="form-group">
                        <label for="itemQuantity">Item Quantity</label>
                        <input v-model="quantity" type="number" class="form-control" id="itemQuantity" placeholder="Item quantity">
                    </div>
                    <div class="form-group">
                        <label for="itemRegion">Item Region</label>
                        <input v-model="region" type="text" class="form-control" id="itemRegion" placeholder="Item region">
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select v-model="category" class="form-control" id="category">
                            <option v-for="(category, categoryKey) in categories" :key="category.id" :value="category">{{ category.name }}</option>
                        </select>
                        <div v-if="category !== null">{{ category.description }}</div>
                    </div>
                    <div v-if="category !== null" class="form-group">
                        <label for="subcategory">Sub Category</label>
                        <select v-model="subCategory" class="form-control" id="subcategory">
                            <option v-for="subCategory in category.sub_categories" :value="subCategory">{{ subCategory.name }}</option>
                        </select>
                        <div v-if="subCategory !== null">{{ subCategory.description }}</div>
                    </div>
                    <div class="form-group">
                        <label for="subcategory">Image</label>
                        <input type="file" @change="onFileChanged" accept="image/*">
                    </div>
                    <!--<div class="form-group">-->
                        <!--<label for="exampleFormControlSelect2">Example multiple select</label>-->
                        <!--<select multiple class="form-control" id="exampleFormControlSelect2">-->
                            <!--<option>1</option>-->
                            <!--<option>2</option>-->
                            <!--<option>3</option>-->
                            <!--<option>4</option>-->
                            <!--<option>5</option>-->
                        <!--</select>-->
                    <!--</div>-->
                    <div class="form-group">
                        <label for="itemDescription">Item Description</label>
                        <textarea v-model="description" class="form-control" id="itemDescription" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Save</button>
                </form>
            </div>
            <div class="col-lg-6">

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: '',
                quantity: 0,
                region: '',
                description: '',
                image: '',
                category: null,
                categories: [],
                subCategories: [],
                subCategory: null
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
            save() {
                let formData = new FormData()
                formData.append('image', this.image)
                formData.append('name', this.name)
                formData.append('category_id', this.category.id)
                formData.append('quantity', this.quantity)
                formData.append('region', this.region)
                axios.post('/admin/inventory', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then(res => {
                        this.$swal({
                            type: 'success',
                            title: 'Record succesfully added!',
                            text: 'We manage to insert the record with success.'
                        })
                    })
                    .catch(err => {
                        this.$swal({
                            type: 'error',
                            title: 'We caught an error!',
                            text: 'Please check and complete the following form.'
                        })
                    })
            },
            onFileChanged (event) {
                this.image = event.target.files[0]
            },
            onUpload() {
                // upload file
            }

        },
        mounted() {
            this.getCategories()
        }
    }
</script>