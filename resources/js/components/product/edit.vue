<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import {useRoute, useRouter} from "vue-router";

const router = useRouter();

let form =ref({
    id:'',
    name:'',
    description:'',
    photo:'',
    quantity:'',
    price:''
})

const props = defineProps({
    id:{
        type:String,
        default:''
    }
})
 const homePage=()=>{
    router.push('/'); 
 }
onMounted(async()=>{
    getSingleProduct()
})

const getSingleProduct=async()=>{
let response = await axios.get(`/api/editProduct/${props.id}`)
form.value =response.data.product
}

const getPhoto=()=>{
    let photo ="/upload/image.png"
    if(form.value.photo){
        if(form.value.photo.indexOf('base64') != -1){
        photo =form.value.photo
    }else{
        photo='/upload/'+form.value.photo
    }
    }
    return photo
}

const updatePhoto=(e)=>{
    let file = e.target.files[0];
    let reader = new FileReader();
    let limit = 1024 * 1024 * 2;
    if(file['size'] > limit){
        return false
    }
    reader.onloadend = (file) =>{
        form.value.photo = reader.result;
    }
    reader.readAsDataURL(file);
}

const updateProduct =()=>{
    const formData = new FormData()
    formData.append('name', form.value.name)
    formData.append('description',form.value.description)
    formData.append('photo',form.value.photo)
    formData.append('quantity',form.value.quantity)
    formData.append('price',form.value.price)

    axios.post(`/api/updateProduct/${form.value.id}`, formData)
    .then((response)=>{
            form.value.name='',
            form.value.description='',
            form.value.photo='',
            form.value.type='',
            form.value.quantity='',
            form.value.price=''
            router.push('/')
            toast.fire({
                icon:"success",
                title:"Product Updated successfully"
            })
        })
        .catch((error)=>{
        });
}

</script>



<template>
    <div class="container text-white">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-6">
                <div class="card  bg-dark">
                <div class="card-header ">
                    <h2>Edit Page</h2>
                    <div class="card-title d-flex justify-content-end">
                    <button class="btn btn-info " @click="homePage()">Home Page</button>
                    </div>
                </div>
                <div class="card-body">           
                   <form>
                        <div class="mb-3">
                            <label  class="form-label">Product Name</label>
                            <input type="text" class="form-control" v-model="form.name" >     
                        </div>
                         <div class="mb-3">
                            <label  class="form-label">Product Quantity</label>
                            <input type="number" class="form-control"  v-model="form.quantity" >     
                        </div>
                         <div class="mb-3">
                            <label  class="form-label">Product Price</label>
                            <input type="number" class="form-control"  v-model="form.price">     
                        </div>
                         <div class="mb-3">
                            <label  class="form-label">Product description</label>
                            <textarea type="text" class="form-control"  v-model="form.description" >  </textarea>   
                        </div>
                        <div class="mb-3">
                            <label  class="form-label">Image</label>
                            <input type="file" @change="updatePhoto" class="form-control" >     
                        </div>
                        <div class="mb-3">
                            <img :src="getPhoto()" height="70"  />   
                        </div>
                        
                   </form>
                   <button @click="updateProduct()" class="btn btn-primary">Update</button>                   
                </div>
            </div>
            
            </div>
            
        </div>
    </div>
</template>

