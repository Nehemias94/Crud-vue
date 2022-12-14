<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD Vue</title>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

      <link rel="stylesheet" href="style.css">
</head>
<body>   
    <div id="app" align="center" width="200">
            <div class="col-lg-12 row">
               <h4 class="col-lg-9 col-sm-9 col-xs-9 col-md-6 mb-4">All Users</h4>

               <button class="btn btn-success btn-md col-lg-3 col-sm-3 col-xs-3  col-md-6 mb-4"
                  data-toggle="modal"
                  data-target="#addUser">Add New Users</button>
            </div>
        <table border="0">
            <thead align="center">
                <th>ID</th>
                <th>NOMBRE</th>
                <th>TELEFONO</th>
            </thead>
            <tbody>
                <tr v-for="(usuario, index) in usuarios">
                    <td> {{ usuario.idUsuario }} </td>
                    <td> {{ usuario.nombre }} </td>
                    <td>  {{ usuario.telefono }} </td>
                    <td> <button value="editar" @click="editUsuario(index, usuario.idUsuario)"> EDITAR </button> </td>
                    <td> <button value="eliminar" @click="deleteUsuario(index, usuario.idUsuario)"> ELIMINAR </button> </td>
                </tr>
            </tbody>
        </table>
        <br>
        <label>Nombre: <input type="text" v-model='nombre' /></label> <br><br>
        <label>Telefono: <input type="number" v-model='telefono'/></label> <br><br>
        <button value="agregar"  @click="addUsuario();"> REGISTRAR </button>
    </div>

    <!-- Add User modal  -->
    <div class="modal fade"
            id="addUser"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
               role="document">
               <div class="modal-content">
                  <div class="modal-header bg-danger">
                     <h5 class="modal-title "
                        id="exampleModalLabel">Add User</h5>
                     <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <form role="form">
                        <label for="name">Name:</label>
                        <input required v-model="nombre"
                           id="nombre"
                           class="form-control"
                           type="text"
                           placeholder="Enter Your Name">

                        <label for="username">Telefono:</label>
                        <input required v-model="telefono"
                           id="telefono"
                           class="form-control"
                           type="text"
                           placeholder="Enter Your User Name">
                     </form>

                  </div>
                  <div class="modal-footer">
                     <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                        <button value="agregar" id="limpiar" data-dismiss="modal" class="btn btn-primary" @click="addUsuario"> REGISTRAR</button>
                  </div>
               </div>
            </div>
         </div>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                    usuarios: [],
                    nombre: '',
                    telefono: ''
            },
            methods: {
                obtenerUsuarios: function() {
                    axios.post('/PruebasCanal/CRUD.php', {
                        request: 1
                    })
                    .then(function(response) {
                        app.usuarios = response.data;
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
                },
                addUsuario: function() {
                    if(this.nombre != '' && this.telefono != '') {
                        axios.post('/PruebasCanal/CRUD.php', {
                            request: 2,
                            nombre: this.nombre,
                            telefono: this.telefono
                        })
                        .then(function(response) {
                            app.obtenerUsuarios();
                            this.hideAddForm();

                            app.nombre = '';
                            app.telefono = '';

                            alert(response.data);
                        })
                        .catch(function () {
                            console.log(error);
                        });
                        this.nombre = '';
                        this.telefono = '';
                    } else {
                        alert("Llenar los campos.");
                    }
                },

                editUsuario: function(index, idUsuario) {
                    var nombre = this.nombre;
                    var telefono = this.telefono;

                    if(nombre != '' && telefono != '') {
                        axios.post('/PruebasCanal/CRUD.php', {
                            request: 3,
                            idUsuario: idUsuario,
                            nombre: nombre,
                            telefono: telefono
                        })
                        .then(function(response) {
                            app.obtenerUsuarios();
                            app.nombre = '';
                            app.telefono = '';
                            alert(response.data);
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                    }
                },

                deleteUsuario: function(index, idUsuario) {
                    axios.post('/PruebasCanal/CRUD.php', {
                        request: 4,
                        idUsuario: idUsuario
                    })
                    .then(function(response) {
                        app.usuarios.splice(index, 1);
                        alert(response.data);
                    })
                    .catch( function(error) {
                        console.log(error);
                    });
                }
            },

            created: function() {
                this.obtenerUsuarios();
            }
        })
        var addUser = new Vue({
            el: '#addUser',
            data: {
                usuarios: [],
                nombre: '',
                telefono: ''
            },
            methods: {
                obtenerUsuarios: function() {
                    axios.post('/PruebasCanal/CRUD.php', {
                        request: 1
                    })
                    .then(function(response) {
                        app.usuarios = response.data;
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
                },
                addUsuario: function() {
                    if(this.nombre != '' && this.telefono != '') {
                        axios.post('/PruebasCanal/CRUD.php', {
                            request: 2,
                            nombre: this.nombre,
                            telefono: this.telefono
                        })
                        .then(function(response) {
                            addUser.obtenerUsuarios();
                            this.hideAddForm();

                            addUser.nombre = '';
                            addUser.telefono = '';

                            alert(response.data);
                        })
                        .catch(function () {
                            console.log(error);
                        });
                        this.nombre = '';
                        this.telefono = '';
                    } else {
                        alert("Llenar los campossss.");
                    }
                }
            }
        })
    </script>
    <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

      <script src=" https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
</body>
</html>