<?php 
    // include_once 'includes/databaseHandling.php'
?>

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
    <title>Main page</title>
</head>

<body>


    <div id="app">

        <div class="d-flex m-3">
            <span class="me-auto p-2"><strong>Product List</strong></span>
            <form action="addproduct.php">
                <input type="submit" class="btn btn-primary p-2 me-3" value="ADD" />
            </form>
            <button @click="deleteAllData()" type="button" class="btn btn-danger p-2" id="delete-product-btn">MASS DELETE</button>
        </div>

        <hr class="ms-4 me-4">

        <div class="container">

            <div class="row" v-for="n,i in (Math.ceil(allData.length/4))">
                <div class=" col border border-dark" v-for="j in 4" >
                    <div class = "delete-checkbox position-relative py-3 d-flex m-1" v-if="4*i+j-1 < allData.length">
                        <input class="position-absolute start-5" type="checkbox" v-model="allData[4*i+j-1].toggle">
                        <ul class="list-unstyled list-inline mx-auto text-center" >
                            <li>{{allData[4*i+j-1].sku}}</li>
                            <li>{{allData[4*i+j-1].name}}</li>
                            <li>{{allData[4*i+j-1].price}}$</li>
                            <li>{{allData[4*i+j-1].specific_attr}}</li>
                            <li>{{allData[4*i+j-1].primary_key}}</li>
                        </ul>
                    </div>


                </div>
            </div>
        </div>

    </div>
    
    <script>
        const { createApp } = Vue

        class Product{
            constructor(data){
                this.sku = data.sku
                this.name = data.name
                this.price = data.price 
                this.specific_attr = data.specific_attr
                this.primary_key = data.primary_key
                this.toggle = false
            }
            toggleCheck(){
                this.toggle = !this.toggle
            }
        }

        createApp({
            methods: {
                fetchAllData(){
                    try {
                        axios.get('./includes/databaseHandling.php',{
                        }).then((res)=>{
                            this.allData = []
                            res.data.forEach(element=>{
                                this.allData.push(new Product(element))
                            })
                        })
                    } catch (error) {
                        console.log(error)
                    }
                }
                ,deleteAllData(){
                    this.allData.forEach(element => {
                        if(element.toggle == true){
                            axios.delete('./includes/databaseHandling.php',{
                                data: {key: element.primary_key}
                            }).then(()=>{this.fetchAllData()})
                        }
                    })
                    
                }
            },
            data() {
                allData = []
                return {
                    allData
                }
            },
            mounted() {
                this.fetchAllData()
            }
        }).mount('#app')

    </script>
</body>

</html>