<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/vue@3" ></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <title>Product Add</title>
</head>

<body>

    <div id="app">

        <div class="d-flex m-3">
            <span class="me-auto p-2"><strong>Product List</strong></span>
            <input type="button" @click="addProduct()" class="btn btn-primary p-2 me-3" value="Save"></input>
            <form action="index.php">
                <input type="submit" class="btn btn-danger p-2" id="delete-product-btn" value="Cancel" />
            </form>
        </div>

        <hr class="ms-4 me-4">


        <div id="product_form" class="d-flex flex-column ms-5">
            <div class = "mb-2">
                <div class="input-group mb-1" style="width:75vw">
                    <span class="input-group-text" style="min-width:9vw" id="basic-addon3">SKU</span>
                    <input v-if = "valid.sku" type="text" class="form-control" v-model="sku" aria-describedby="basic-addon3" id="sku">
                    <input v-else type="text" class="form-control is-invalid" v-model="sku" aria-describedby="basic-addon3" id="sku">
                </div>
                <div v-if = "!valid.sku" class = "ms-2 mb text-danger"> {{skuErrorText}} </div>
            </div>

            <div class="mb-2">
                <div class="input-group mb-1" style="width:75vw">
                    <span class="input-group-text" style="min-width:9vw" id="basic-addon3">Name</span>
                    <input v-if = "valid.name" type="text" class="form-control" v-model="name" aria-describedby="basic-addon3" id="name">
                    <input v-else type="text" class="form-control is-invalid" v-model="name" aria-describedby="basic-addon3" id="name">
                </div>
                <div v-if = "!valid.name" class = "ms-2 mb text-danger"> Please, provide the data of indicated type</div>
            </div>
            
            <div class="mb-2">
                <div class="input-group mb-1" style="width:75vw">
                    <span class="input-group-text" style="min-width:9vw" id="basic-addon3">Price($)</span>
                    <input v-if = "valid.price" type="text" class="form-control " v-model="price" aria-describedby="basic-addon3" id="price">
                    <input v-else type="text" class="form-control is-invalid" v-model="price" aria-describedby="basic-addon3" id="price">
                </div>
                <div v-if = "!valid.price" class = "ms-2 mb text-danger"> Please, provide the data of indicated type</div>
            </div>

            <div class="input-group mb-3" style="width:75vw">
                <span class="input-group-text" style="min-width:9vw" id="basic-addon3">Type Switcher</span>
                <select class="form-select" aria-label="Default select example" id="productType">
                    <option @click="count = 0; resetTypeSwitcherData(); changeTypeSwitcher()" selected>Type Switcher</option>
                    <option @click="count = 1; resetTypeSwitcherData(); changeTypeSwitcher()" value="1">DVD</option>
                    <option @click="count = 2; resetTypeSwitcherData(); changeTypeSwitcher()" value="2">Furniture</option>
                    <option @click="count = 3; resetTypeSwitcherData(); changeTypeSwitcher()" value="3">Book</option>
                </select>
            </div>


            <div v-if="count==1" class="mb-2">
                <div class="input-group mb-1" style="width:75vw">
                    <span class="input-group-text" style="min-width:9vw" id="basic-addon3">Size (MB)</span>
                    <input v-if = "valid.size" type="text" class="form-control " v-model="size" aria-describedby="basic-addon3" id="size">
                    <input v-else type="text" class="form-control is-invalid" v-model="size" aria-describedby="basic-addon3" id="size">
                </div>
                <div v-if = "!valid.size" class = "ms-2 mb text-danger"> Please, provide the data of indicated type</div>
            </div>

            <div v-else-if="count==2" style="width:75vw">

                <div class="mb-2">
                    <div class="input-group mb-1" >
                        <span class="input-group-text" style="min-width:9vw" id="basic-addon3">Height (CM)</span>
                        <input v-if = "valid.height" type="text" class="form-control " v-model="height" aria-describedby="basic-addon3" id="height">
                        <input v-else-if = "!valid.height" type="text" class="form-control is-invalid" v-model="height" aria-describedby="basic-addon3" id="height">
                    </div>
                    <div v-if = "!valid.height" class = "ms-2 mb text-danger"> Please, provide the data of indicated type</div>
                </div>

                <div class="mb-2">
                    <div class="input-group mb-1">
                        <span class="input-group-text" style="min-width:9vw" id="basic-addon3">Width (CM)</span>
                        <input v-if = "valid.width" type="text" class="form-control " v-model="width" aria-describedby="basic-addon3" id="width">                    
                        <input v-else-if = "!valid.width" type="text" class="form-control is-invalid" v-model="width" aria-describedby="basic-addon3" id="width">
                    </div>
                    <div v-if = "!valid.width" class = "ms-2 mb text-danger"> Please, provide the data of indicated type</div>
                </div>


                <div class="mb-2">
                    <div class="input-group mb-1">
                        <span class="input-group-text" style="min-width:9vw" id="basic-addon3">Length (CM)</span>
                        <input v-if = "valid.length" type="text" class="form-control " v-model="length" aria-describedby="basic-addon3" id="length">
                        <input v-else-if = "!valid.length" type="text" class="form-control is-invalid" v-model="length" aria-describedby="basic-addon3" id="length">
                    </div>
                    <div v-if = "!valid.length" class = "ms-2 mb text-danger"> Please, provide the data of indicated type</div>
                </div>

            </div>

            <div v-else-if="count==3" style="width:75vw">
                <div class="mb-2">
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="basic-addon3">Weight (KG)</span>
                        <input v-if = "valid.weight" type="text" class="form-control " v-model="weight" aria-describedby="basic-addon3" id="weight">
                        <input v-else-if = "!valid.weight" type="text" class="form-control is-invalid" v-model="weight" aria-describedby="basic-addon3" id="weight">
                    </div>
                    <div v-if = "!valid.weight" class = "ms-2 mb text-danger"> Please, provide the data of indicated type</div>
                </div>
            </div>

        </div>

    </div>
    
    <script>
        const { createApp } = Vue

        createApp({
            methods: {
                addProduct(){
                    if(this.checkFormData() == true){
                        console.log("SKU: " + this.sku);

                        let formData = new FormData();

                        formData.append("sku", this.sku);
                        formData.append("name", this.name);
                        formData.append("price",this.price);

                        if(count == 1){
                            formData.append("specific_attr", this.size + " MB");
                        }
                        else if(count == 2){
                            formData.append("specific_attr", this.height+"x"+this.width+"x"+this.length)
                        }
                        else if(count == 3){
                            formData.append("specific_attr", this.weight + "KG");
                        }
                        
                        var contact = {};
                        formData.forEach(function(value, key){
                            console.log(key + "=" +value)
                            contact[key] = value;
                        });

                        axios.post('./includes/databaseHandling.php', formData,{
                            config: { headers: {'Content-Type': 'multipart/form-data'}}
                        })
                        .then((res)=>{
                            console.log(res)
                            window.location.href = "index.php"
                        })
                        .catch((err)=>{
                            if(err.response){
                                this.skuErrorText = "SKU Already in Use"
                                this.valid.sku = false
                            }
                        });
                    }
                },

                resetTypeSwitcherData(){
                    this.size = ""
                    this.height = ""
                    this.width = ""
                    this.length = ""
                    this.weight = "";
                },

                resetFormData(){
                    this.resetTypeSwitcherData()
                    this.sku = ""
                    this.name = ""
                    this.price = 0;
                    this.count = 0;
                },

                checkFormData(){
                    flag = true;
                    if (this.sku == ""){
                        console.log("invalid")
                        this.valid.sku = flag = false
                        
                    }
                    if (this.name == ""){
                        this.valid.name = flag = false
                    }
                    if (this.price == "" || isNaN(this.price)){
                        this.valid.price = flag = false
                    }
                    if(this.count == 1){
                        if (this.size == "" || isNaN(this.size)){
                            this.valid.size = flag = false
                            
                        }
                    }
                    else if(this.count == 2){
                        if (this.height == "" || isNaN(this.height)){
                            this.valid.height = flag = false
                            
                        }
                        if (this.width == "" || isNaN(this.width)){
                            this.valid.width = flag = false
                            
                        }
                        if (this.length == "" || isNaN(this.length)){
                            this.valid.length = flag = false
                            
                        }
                    }
                    else if(this.count == 3){
                        if (this.weight == "" || isNaN(this.weight)){
                            this.valid.weight = flag = false
                        }
                    }
                    return flag
                },

                changeTypeSwitcher(){
                    if (this.count == 0) {
                        this.buttonName = "Type Switcher"
                    }
                    else if(this.count == 1){
                        this.buttonName = "DVD"
                    }
                    else if(this.count == 2){
                        this.buttonName = "Furniture"
                    }
                    else if(this.count == 3){
                        this.buttonName = "Book"
                    }
                }
                
            },
            data() {
                buttonName = "Type Switcher"
                count = 0

                valid = {
                    sku:true,
                    name:true,
                    price:true,
                    size:true,
                    height:true,
                    width:true,
                    length:true,
                    weight:true
                }
                skuErrorText = "Please, provide the data of indicated type"
                sku = ""
                name = "" 
                price = ""
                size = ""
                height = ""
                width = ""
                length = ""
                return {
                    sku,name,price,size,height,width,length,count,buttonName,valid,skuErrorText
                }
            }
        }).mount('#app')
    </script>
</body>

</html>