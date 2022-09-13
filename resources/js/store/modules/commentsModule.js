import axios from "axios";
import router from '../../router/router.js'

export default { 
    state: {
        imgPath: null,
        comments: [],
    },
    mutations: {
        SET_PATH(state, path) {
            state.imgPath = path;
        },
        SET_COMMENT(state, comment) {
            state.comments.push(comment)
        },
        SET_PATH_ON_NULL(state) {
            state.imgPath = null
        },
        SET_COMMENTS_ON_NULL(state) {
            state.comments.length=0;
        }
    },
    getters: {
        getPath(state) {
            return state.imgPath
        },
        getComments(state) {
            return state.comments
        }
    },
    actions: {
        moveImgToStorage({commit}, params) {
            var formData = new FormData();
            formData.append("image", params.imgFile);

            axios.post('/api/comment/image', formData)
                .then(response => {
                    commit('SET_PATH', response.data)

                    const url = response.data.url; // Get url from response
                    params.Editor.insertEmbed(params.cursorLocation, "image", url);
                    params.resetUploader();
                })
                    .catch(err => {
                    console.log(err);
                });
        },
        storeComment({commit}, params) {
            return new Promise((resolve,reject) => {
                axios.post('/api/comment/store', {
                    media_path: params.path,
                    content: params.comment,
                    user_id: params.user_id,
                    report_id: params.report_id,

                    conference_title: params.conference_title,
                    username: params.username,
                    report_topic: params.report_topic,
                    report_author:params.report_author
                }).then(response => {
                    commit('SET_COMMENT', response.data.data)
                    commit('SET_PATH_ON_NULL')
                    resolve(response.data.data)
                }).catch(error => {
                    console.log(error)
                    reject(error)
                })
            })  
        },
        fetchComments({commit}, report_id) {
            commit('SET_COMMENTS_ON_NULL')
            return new Promise((resolve, reject) => {
                axios.get('/api/comment/fetch/'+report_id).then(response => {
            //      response.data.forEach(element => {
            //          commit('SET_COMMENT', element)
            //      })
                    resolve(response.data) 
                })
            })
          
        }
    }
}