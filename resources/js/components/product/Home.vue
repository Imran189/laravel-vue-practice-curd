<script setup>
import { useRouter } from "vue-router";
import { onMounted,ref } from "vue";
import axios from "axios";
import Swal from "sweetalert2";
import { Result } from "postcss";


const router = useRouter()
let products = ref([])

 onMounted(async()=>{
  getProducts()
 })


 const ourImage=(img)=>{
     return "upload/"+img
 }
 const newProduct=()=>{
    router.push('/product/new')
 }

 const getProducts = async() =>{
    let response = await axios.get("api/get_all_product")
    products.value = response.data.products
    console.log('products', products.value)
}

const onEdit=(id)=>{
 router.push('/product/edit/'+id)
}
const deleteProduct=(id)=>{
     Swal.fire({
         title:'Are You Sure',
         text:"You Can Go back",
         icon:"warning",
         showCancelButton:true,
         confirmButtonColor:'#3085d6',
         cancelButtonText:'Cancel',
         cancelButtonColor:'#d33',
         confirmButtonText:'Yes, delete it',
     })
     .then((result)=>{
         if(result.value){
             axios.get('/api/deleteProduct/'+id)
             .then(()=>{
                 Swal.fire(
                     'Delete',
                     'Product deleted Successfully',
                     'Success'
                 )  
                 getProducts()
             })
              .catch(()=>{
                 Swal.fire("Failed!", "There was Something wrong", "Warning")
             })
         }
     })
}
</script>



<template>
<div class="row bg-dark">
    <div class="col-2"></div>
    <div class="col-8">
        <div class="card bg-dark text-white">
        <div class="card-header">
            <p class="text-center pt-2 fs-4">Product Page</p>
        </div>
            <div class="card-text d-flex justify-content-end">
            <button  class="btn btn-primary "  @click="newProduct">Add product</button>
            </div>
            <div class="card-body">
                <table class="table table-dark table-striped">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                    </tr>
                </thead>

                 <tbody v-if="products.length > 0">
                       
                        <tr v-for="item in products" :key="item.id">
                        <th>{{item.id}}</th>
                        <td><img :src="ourImage(item.photo)" style="height: 40px;" v-if="item.photo"></td>
                        <td>{{item.name}}</td>
                        <td>{{item.quantity}}</td>
                        <td>{{item.price}}</td>                       
                        <td>
                            <button @click="onEdit(item.id)" class="btn btn-primary mx-2">Edit</button>
                            <button @click="deleteProduct(item.id)" class="btn btn-danger mx-2">Delete</button>
                        </td>
                        </tr> 
                    </tbody>
                        <p v-else>Product No Found</p> 
                                                          
                </table>
            </div>
        </div>
    </div>
    </div>

    
</template>

