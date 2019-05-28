let f = async (url, method, body) => {
    let options = {
        method: method,
        body: body
    }
    let res = await fetch(`/${url}`, options)
    return res.json()
}

let app = new Vue({
    el: '#app',
    data: {
        reg: {
            status: false,
            errors: [],
            name: '',
            login: '',
            email: '',
            password: '',
            password_confirm: ''
        }
    },
    methods: {
        async registration() {
            let formData = new FormData()

            formData.append('name', this.reg.name)
            formData.append('login', this.reg.login)
            formData.append('email', this.reg.email)
            formData.append('password', this.reg.password)
            formData.append('password_confirm', this.reg.password_confirm)

            let res = await f('reg', 'POST', formData)

            if (res.status == true) {
                this.reg.status = true
            } else {
                this.reg.errors = res
            }

            //alert(this.reg.errors.name)

        },

    }
})