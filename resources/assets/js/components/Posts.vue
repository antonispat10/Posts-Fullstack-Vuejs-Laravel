<template>
    <div>
        <h2>Posts</h2><br>
        <form @submit.prevent="addPost()">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Title" v-model="post.title">
                <textarea class="form-control" placeholder="Body" v-model="post.body"></textarea>
                <button type="submit" class="btn btn-light btn-block">Save</button>
            </div>
        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchPosts(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item"> <a> Page {{ pagination.current_page }} of {{pagination.last_page}}</a></li>
                <li  v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchPosts(pagination.next_page_url)">Next</a></li>
            </ul>
        </nav>
        <div class="card card-body" v-for="post in posts" v-bind:key="post.id">


            <h3>{{ post.title }}</h3><br><br>
            <p>{{ post.body }}</p><br>
            <hr>
            <button @click="editPost(post)" class="btn btn-warning mb-2">Edit</button>
            <button @click="deletePost(post.id)" class="btn btn-danger">Delete</button>
            <h3>{{ post.title }}</h3><br><br>
            <p>{{ post.body }}</p><br>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                posts: [],
                post: {
                    id:'',
                    title:'',
                    body:''
                },
                post_id:'',
                pagination: {},
                edit: false
            }
        },

        created() {
            this.fetchPosts();
        },
        methods: {
            fetchPosts(page_url){
                let vm = this;
                page_url = page_url || '/api/posts'
                fetch(page_url)
                    .then(res => res.json())
            .then(res => {
                    this.posts = res.posts.data,
                    this.pages = res.posts,
                    console.log(this.posts);
                    console.log(this.pages);
                vm.makePagination(this.pages);
            });
            },
            makePagination(pages) {
                let pagination = {
                    current_page: pages.current_page,
                    last_page: pages.last_page,
                    next_page_url: pages.next_page_url,
                    prev_page_url: pages.prev_page_url
                };
                this.pagination = pagination;
            },
            deletePost(id) {
                if(confirm('Are you sure?')) {
                    fetch('api/post/' +id,{
                        method:'delete'
                    })
                        .then(res =>res.json())
                .then(data => {
                        alert('Post Removed');
                    this.fetchPosts();
                })
                .catch(err =>console.log())
                }
            },
            addPost() {
                if(this.edit == false) {
                    fetch('api/post/store', {
                        method:'post',
                        body:JSON.stringify(this.post),
                        headers: {
                            'content-type' : 'application/json'
                        }
                    })
                        .then(res => res.json())
                .then(data=> {

                    this.post.title = '';
                    this.post.body = '';
                    alert('Post Added');
                    this.fetchPosts();
                })
                } else{
                    fetch('api/post/'+this.post.id +'/edit', {
                        method:'put',
                        body:JSON.stringify(this.post),
                        headers: {
                            'content-type' : 'application/json'
                        }
                    })
                        .then(res => res.json())
                .then(data=> {
                        this.post.title = '';
                    this.post.body = '';
                    alert('Post Updated');
                    this.fetchPosts();
                })
                }
            },
            editPost(post){
                this.edit = true;
                this.post.id = post.id;
                this.post.post_id = post.id;
                this.post.title = post.title;
                this.post.body = post.body;
                }
                this.pagination = pagination;
            }
        }
    };
</script>
