<template>
  <div class="form-create">
    <div class="alert alert-danger" style="text-align: center;" role="alert" v-if="errorMessage != ''">{{errorMessage}}</div>
    <div class="container col-md-6 col-lg-6 col-xl-4">
        <div class="d-flex justify-content-center w-10">
            <img class="w-75" src="https://memorar.fot.br/images/company/memorar.fot.br.png" alt="Loja Memorar">
        </div>

        <h1 class="h5 fw-bold text-center mb-4 mt-4">Crie sua conta na Memorar</h1>

        <form id="create-account" v-on:submit.prevent="onSubmit" class="needs-validation" novalidate>

            <div class="form-floating mb-3 ">
                <input class="form-control" id="complete_name" type="text" name="complete_name"
                    placeholder="Seu nome comepleto" required pattern=".{2,}" 
                    v-model="userForm.complete_name"/>
                <label for="complete_name">*Nome completo</label>
                <div class="invalid-feedback">Digite seu telefone completamente.</div>
                <div class="valid-feedback">O nome deve ter no minimo 2 letras.</div>
            </div>

            <div class="row gx-3">
                <div class="form-floating mb-3 col-sm-6">
                    <input class="form-control" id="phone" type="tel" name="phone" placeholder="Seu telefone"
                        pattern="\(?\b([0-9]{2,3}|0((x|[0-9]){2,3}[0-9]{2}))\)?\s*[0-9]{4,5}[- ]*[0-9]{4}\b" 
                        v-model="userForm.phone" />
                    <label for="phone">Telefone</label>
                    <div class="invalid-feedback">Digite seu telefone completamente.</div>
                    <div class="valid-feedback">Este campo não é obrigatório.</div>
                </div>

                <div class="form-floating mb-3 col-sm-6">
                    <input class="form-control" id="birthday" type="date" name="birthday" required max="9999-12-31"
                    v-model="userForm.birthday" />
                    <label for="birthday">*Data de Nascimento</label>
                    <div class="invalid-feedback">Selecione sua data de nascimento.</div>
                </div>
            </div>


            <div class="form-floating mb-3">
                <input class="form-control" id="email" type="email" name="email" placeholder="seu@email.com"
                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required
                    v-model="userForm.email" />
                <label for="email">*E-mail</label>
                <div class="invalid-feedback">Digite seu e-mail por completo.</div>
            </div>

            <div class="row gx-3">
                <div class="form-floating mb-3 col-sm-6">
                    <input class="form-control" id="password" type="password" name="password"
                        placeholder="Crie uma senha" pattern=".{8,16}" title="Digite uma senha entre 8 e 16 caracteres."
                        required />
                    <label for="password">*Crie uma senha</label>
                    <div class="invalid-feedback">Digite uma senha de 8-16 caracteres.</div>
                    <small class="mb-3">Sua senha deve conter entre 8-16 caracteres.</small>
                </div>

                <div class="form-floating col-sm-6">
                    <input class="form-control" id="password_repeat" type="password" name="password_repeat"
                        placeholder="Repita sua senha" pattern=".{8,16}"
                        title="Digite uma senha entre 8 e 16 caracteres." required />
                    <label for="password_repeat">*Repita sua senha</label>
                    <div class="invalid-feedback">Repita a sua senha.</div>
                </div>
            </div>

            <div class="form-floating mb-3 mt-3">
                <input class="form-control" id="cpf" type="text" name="cpf" placeholder="Seu CPF"
                    pattern="^([-\.\s]?(\d{3})){3}[-\.\s]?(\d{2})$" required
                    v-model="userForm.cpf" />
                <label for="cpf">*CPF</label>
                <div class="invalid-feedback">Digite o CPF.</div>
            </div>

            <div class="w-100 d-flex justify-content-center">
                <input class="p-2 px-5 w-auto btn btn-primary " type="submit" name="Criar Conta" />
            </div>
        </form>


        <!-- 
            Table
         -->

        <table class="table table-striped mt-5" id="table_db">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="user in userData" :key="user.id">
              <td>{{user.complete_name}}</td>
              <td>{{user.email}}</td>
            </tr>
            </tbody>
        </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FormCreateAccount',
  data: function() {
    return {
    userForm: {},
    errorMessage: '',
    userData: []
    }
  },
  methods: {
    onSubmit: function(event) {
        const FORM_ARR_INPUTS = Object.values(document.querySelectorAll("form#create-account input"));
        event.preventDefault();

        // Checking all required inputs and testing regex pattern before send
        function checkExpression(input) {
            //  Checking by regex (pattern) if the inputs required are filled with correctly values  
            if (input.hasAttribute('required') && input.hasAttribute('pattern')) {
                const regex_pattern = input.pattern;
                const value = input.value;
                const re = new RegExp(regex_pattern);

                if (re.test(value) == false)
                    return false;
            }

            // Checking if date have 10 chars (e.g. 31-12-9999)
            if (input.hasAttribute('required') && input.type.includes("date")) {
                if (input.value.length === 10){
                    return true;
                }else{
                    return false;
                }
            }
            
            // Checking if phone number do not have wrong value
            if (input.id.includes("phone")) {
                if (input.value.length > 0) {
                    const regex_pattern = input.pattern;
                    const value = input.value;
                    const re = new RegExp(regex_pattern);

                    if (re.test(value) == false)
                        return false;
                }
            }

            return true;
        }

        const CHECKED_INPUTS = FORM_ARR_INPUTS.filter(checkExpression);

        // Checking if the password inputs have value and if it's same.
        function getIndexById(arr, identifier) {
          return arr.findIndex(input =>  input.id == identifier);
        }

        const INPUT_PASS = CHECKED_INPUTS[getIndexById(CHECKED_INPUTS, "password")];
        const INPUT_PASS_REPEAT = CHECKED_INPUTS[getIndexById(CHECKED_INPUTS, "password_repeat")];
        
        const PASSWORD_EQUALS = INPUT_PASS != undefined && INPUT_PASS_REPEAT != undefined ?
            (INPUT_PASS.value === INPUT_PASS_REPEAT.value) : false;

        // Cheking if all inputs have values
        const ALL_INPUTS_FILLED = CHECKED_INPUTS.length === FORM_ARR_INPUTS.length ? true : false;

        // Executing code
        // If all inputs are filled and passwords inputs are equals values we can send the form
        if ((ALL_INPUTS_FILLED == true)) {
            if ((PASSWORD_EQUALS == true)) {
                const params = 
                {
                    complete_name: `${this.userForm.complete_name}`, 
                    phone: `${this.userForm.phone}`,
                    birthday: `${this.userForm.birthday}`,
                    email: `${this.userForm.email}`,
                    cpf: `${this.userForm.cpf}`,
                    password: `${this.userForm.password}`
                }

                this.pushData(params);
            } else {
                // Sending visual error fields and message (password incorrect)
                INPUT_PASS.value = "";
                INPUT_PASS_REPEAT.value = "";                
                this.errorMessage = "As senhas não coincidem, por favor tente novamente.";
                const FORM = event.target; FORM.classList.add('was-validated'); 
            }
        } else {
            // Sending visual error fields and message (missing fields)
            this.errorMessage = "Verifique se todos os campos estão preenchidos corretamente.";
            const FORM = event.target; FORM.classList.add('was-validated');
        }
    },
    pushData: function(data) {
        this.errorMessage=this.errorMessage != '' ? this.errorMessage = '' : '';
        this.userForm = [];
        const t = this;

        // Fetch
        fetch('http://localhost:9090/users/register?' + new URLSearchParams(data), {
            method: 'POST'
        }).then(response => response)
        .then((json) => {
            if (json.status == 201) {
                t.userData.push({
                    complete_name: `${data.complete_name}`,
                    email: `${data.email}`
                });
            }
        })
        .catch(error => console.log('Failed : ' + error.message));        
    },
    getUsers: async function(){
        // XML
        let Req = new XMLHttpRequest();
        const t = this;

        Req.addEventListener("load", function(event){
            const response = JSON.parse(event.target.response);
            t.userData = response;
        });
        
        Req.open("GET", "http://localhost:9090/users");
        Req.send();
    }

  },
  mounted: function() {
      this.getUsers();
  }
    
  // props: {
  //   msg: String
  // }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    form#create-account label {
        left: auto !important;
        opacity: 0.8;
    }
</style>