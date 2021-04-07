import axios from 'axios'
import router from '../../router/index.js'

const state = {
    user: '',
    loggedin: false,
    admin: false,
    dashPage: 'feeds',
    registerStep: 1,
    submissionStep: 1,
    errors: {
        login: {},
        register: {},
        submission: {}
    },
    message: '',
    messageDialog: ''
};
const getters = {};
const actions = {
    register({}, user) {
        axios
        .post("/api/auth/register", user, {
            headers: {
                'accept': 'application/json',
                'Accept-Language': 'en-US,en;q=0.8',
                'Content-Type': `multipart/form-data`,
            }
        })
        .then(response => {
            if (response.data.response == 'continue' && state.registerStep == 1) {
                state.registerStep = 2;
            } else if (response.data.response == 'success') {
                state.registerStep = 1;
                state.message = response.data.message;
                router.push({path: '/'});
                setTimeout(() => {
                    state.message = "";
                    state.messageDialog = "";
                }, 4050);
            }
        })
        .catch(e => {
            if (e.response.status == 422) {
                state.errors.register = e.response.data.errors;
                state.message = "";
            }
        });
    },

    login({}, user) {
        axios
        .post("/api/auth/login", {
            email: user.email,
            password: user.password
        })
        .then((response) => {
            state.user = response.data.user;
            state.loggedin = response.data.loggedin;
            state.admin = response.data.isadmin;
            state.messageDialog = response.data.message;
            if(response.data.access_token) {
                //saving token in local storage
                localStorage.setItem(
                    "access_token", response.data.access_token
                )
            }
        })
        .catch(e => {
            if (e.response.status == 422) {
                state.errors.login = e.response.data.errors;
                state.message = "";
            }
        });
    },

    logout() {
        localStorage.removeItem("access_token");
    },
    
    getUser({commit}) {
        if(localStorage.hasOwnProperty("access_token")) {
            axios
            .get("/api/auth/current", {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem("access_token")
                }
            })
            .then(response => {
                if (response.data != null) {
                    commit('setUser', response.data);
                    commit('setUserStatus', response.data);
                    commit('setUserAdmin', response.data);
                }
            });
        }
    },

    start({}, submission) {
        if(localStorage.hasOwnProperty("access_token")) {
            axios
            .post("/api/campaign/start", submission, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem("access_token"),
                    'accept': 'application/json',
                    'Accept-Language': 'en-US,en;q=0.8',
                    'Content-Type': `multipart/form-data`,
                }
            })
            .then(response => {
                if (response.data.response == 'step-2' && state.submissionStep == 1) {
                    state.submissionStep = 2;
                } else if (response.data.response == 'step-3' && state.submissionStep == 2) {
                    state.submissionStep = 3;
                } else if (response.data.response == 'success' && state.submissionStep == 3) {
                    state.message = response.data.message;
                    state.submissionStep = 1;
                    router.push({path: '/'});
                    setTimeout(() => {
                        state.message = "";
                        state.messageDialog = "";
                    }, 4050);
                }
            })
            .catch(e => {
                if (e.response.status == 422) {
                    state.errors.submission = e.response.data.errors;
                    state.message = "";
                }
            });
        }
    },
};
const mutations = {
    setUser(state, data) {
        state.user = data.user;
    },
    setUserStatus(state, data) {
        state.loggedin = data.loggedin;
    },
    setUserAdmin(state, data) {
        state.admin = data.isadmin;
    },
    setDashboardPage(state, data) {
        state.dashPage = data;
    },
    setRegisterStep(state, data) {
        state.registerStep = data;
    },
    setSubmissionStep(state, data) {
        state.submissionStep = data;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
