<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">GitHub</div>
          <div class="card-body">
            <div class="form-group">
              <input type="text" class="form-control" v-model="name">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" @click="search">Search</button>
            </div>
            <div class="container">
              <p>Total: {{ store.length }}</p>
              <ul class="list-group">
                <li class="list-group-item" v-for=" (t, index) in repoTemplate">
                  <div class="name">{{ t.name }}</div>
                  <div class="right">
                    <button class="btn btn-primary"
                      :disabled="disabledClone.find(i => i === index)"
                      v-if="!repos.find(r => r.repo_name === t.name)"
                      @click="saveRepo(t, index)">clone</button>
                    <span class="badge badge-primary badge-pill">
                      <i class="far fa-star"></i>{{ t.stargazers_count }}
                    </span>
                  </div>
                </li>
              </ul>
              <button class="btn btn-primary" v-if="isFull" @click="loadmore">
                Load more
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'SearchRepo',
  props: {
    id: {
      type: Number,
      required: true
    },
    repos: {
      type: Array
    }
  },
  data() {
    return {
      name: '',
      store: [],
      repoTemplate: [],
      number: 30,
      current: 0,
      disabledClone: []
    }
  },
  computed: {
    isFull() {
      if (!this.store.length || this.store.length === this.repoTemplate.length) return false
      return this.store.length >= this.repoTemplate.length && this.store.length > this.number
    }
  },
  methods: {
    async getRepos() {
      const { data } = await axios.get('/api/repos', {
        params: {
          name: this.name
        }
      })
      this.store = data.data
      this.repoTemplate = this.store.filter((r, i) => i < this.number)
      this.current = this.repoTemplate.length
    },
    search() {
      this.getRepos()
    },
    loadmore() {
      this.store.forEach((r, i) => {
        if (i >= this.current && i < (this.current + this.number)) {
          this.repoTemplate.push(r)
        }
      })
      this.current = this.repoTemplate.length
    },
    async saveRepo(template, index) {
      this.disabledClone.push(index)
      const params = {
        user_id: this.id,
        repo_name: template.name,
        owner: template.owner.login
      }
      await axios.post('/api/clone-repo', params)
    }
  },
  mounted() {
    console.log('Component mounted.')
  }
}
</script>

<style scoped>
.list-group-item {
  display: flex;
  justify-content: space-between;
}
</style>
