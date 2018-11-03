<template>
    <div>
        <h2>Questionnaires</h2>
        <form @submit.prevent="addQuestionnaire" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Title"
                    v-model="questionnaire.title">
            </div>
            <div class="form-group">
                <textarea class="form-control" placeholder="Description"
                    v-model="questionnaire.description"></textarea>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Choice1"
                    v-model="questionnaire.choice_1">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Choice2"
                    v-model="questionnaire.choice_2">
            </div>
            <button type="submit" class="btn btn-light btn-block">Save</button>
        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
            <li v-bind:class="{disabled: !pagination.prev_page_url}" class="page-item"><a class="page-link" href="#" 
                @click="fetchQuestionnaires(pagination.prev_page_url)">Previous</a></li>

            <li class="page-item disabled"><a class="page-link text-dark" href="#">
                Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li> 

            <li v-bind:class="{disabled: !pagination.next_page_url}" class="page-item"><a class="page-link" href="#" 
                @click="fetchQuestionnaires(pagination.next_page_url)">Next</a></li>
            </ul>
        </nav>
        <div class="card mb-2" v-for="questionnaire in questionnaires" v-bind:key="questionnaire.id">
            <div class="card-body">
                <h3>{{ questionnaire.title }}</h3>
                <p>{{ questionnaire.description }}</p>
                <button type="button" class="btn btn-primary">{{ questionnaire.choice_1 }}</button>
                <button type="button" class="btn btn-success">{{ questionnaire.choice_2 }}</button>
                <hr>
                <button @click="editQuestionnaire(questionnaire)" class="btn btn-warning">Edit</button>
                <button @click="deleteQuestionnaire(questionnaire.id)" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                questionnaires: [],
                questionnaire: {
                    questionnaire_id: '',
                    title: '',
                    description: '',
                    choice_1: '',
                    choice_2: ''
                }, 
                pagination: {},
                edit: false
            }
        },

        created() {
            this.fetchQuestionnaires();
        },

        methods: {
            fetchQuestionnaires(page_url) {
                page_url = page_url || 'api/questionnaires'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.questionnaires = res.data;
                    this.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err))
            },
            makePagination(meta, links)  {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                }

                this.pagination = pagination;
            },
            deleteQuestionnaire(id) {
                if(confirm('Are You Sure?')) {
                    fetch(`api/questionnaire/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('Questionnaire Removed');
                        this.fetchQuestionnaires();
                    })
                    .catch(err => console.log(err))
                }
            },
            addQuestionnaire() {
                if(this.edit === false) {
                    // Add
                    fetch('api/questionnaire', {
                        method: 'post',
                        body: JSON.stringify(this.questionnaire),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.questionnaire.title = '';
                        this.questionnaire.description = '';
                        this.questionnaire.choice_1 = '';
                        this.questionnaire.choice_2 = '';
                        alert('Questionnaire Added');
                        this.fetchQuestionnaires();
                    })
                    .catch(err => console.log(err))
                } else {
                    // Update
                    fetch('api/questionnaire', {
                        method: 'put',
                        body: JSON.stringify(this.questionnaire),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.questionnaire.title = '';
                        this.questionnaire.description = '';
                        this.questionnaire.choice_1 = '';
                        this.questionnaire.choice_2 = '';
                        alert('Questionnaire Updated');
                        this.fetchQuestionnaires();
                    })
                    .catch(err => console.log(err))
                }
            },
            editQuestionnaire(questionnaire) {
                this.edit = true;
                this.questionnaire.questionnaire_id = questionnaire.id;
                this.questionnaire.title = questionnaire.title;
                this.questionnaire.description = questionnaire.description;
                this.questionnaire.choice_1 = questionnaire.choice_1;
                this.questionnaire.choice_2 = questionnaire.choice_2;
            }
        }
    }
</script>