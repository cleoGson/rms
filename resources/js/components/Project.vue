<template>
<section class="content">
    <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Project Component</div>
                    <div class="card-body">
                       <div class="projects">
        <div class="tableFilters">
            <input class="input" type="text" v-model="tableData.search" placeholder="Search Table"
                   @input="getProjects()">

            <div class="control">
                <div class="select">
                    <select v-model="tableData.length" @change="getProjects()">
                        <option v-for="(records, index) in perPage" :key="index" :value="records">{{records}}</option>
                    </select>
                </div>
            </div>
        </div>
        <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
            <tbody>
                <tr v-for="project in projects" :key="project.id">
                    <td>{{project.id}}</td>
                    <td>{{project.deadline}}</td>
                    <td>{{project.budget}}</td>
                    <td>{{project.status}}</td>
                    <td>
                       <a href="#" @click="editModel(user)"> <i class="fas fa-edit blue"></i> </a>/
                    </td>
                    <td>Delete</td>
                </tr>
            </tbody>
        </datatable>
        <pagination :pagination="pagination"
                    @prev="getProjects(pagination.prevPageUrl)"
                    @next="getProjects(pagination.nextPageUrl)">
        </pagination>
    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>


<script>
import Datatable from "./Datatable.vue";
import Pagination from "./Pagination.vue";
export default {
  components: { datatable: Datatable, pagination: Pagination },
  created() {
    this.getProjects();
  },
  data() {
    let sortOrders = {};
    let columns = [
      { width: "", label: "ID", name: "id" },
      { width: "", label: "Deadline", name: "deadline" },
      { width: "", label: "Budget", name: "budget" },
      { width: "", label: "Status", name: "status" },
      { width: "", label: "Edit", name: "" },
      { width: "", label: "Update", name: "" }
    ];
    columns.forEach(column => {
      sortOrders[column.name] = -1;
    });
    return {
      projects: [],
      columns: columns,
      sortKey: "deadline",
      sortOrders: sortOrders,
      perPage: ["10", "20", "30","100","1000","5000"],
      tableData: {
        draw: 0,
        length: 10,
        search: "",
        column: 0,
        dir: "desc"
      },
      pagination: {
        lastPage: "",
        currentPage: "",
        total: "",
        lastPageUrl: "",
        nextPageUrl: "",
        prevPageUrl: "",
        from: "",
        to: ""
      }
    };
  },
  methods: {
    getProjects(url = "/projects") {
      this.tableData.draw++;
      axios
        .get(url, { params: this.tableData })
        .then(response => {
          let data = response.data;
          if (this.tableData.draw == data.draw) {
            this.projects = data.data.data;
            this.configPagination(data.data);
          }
        })
        .catch(errors => {
          console.log(errors);
        });
    },
    configPagination(data) {
      this.pagination.lastPage = data.last_page;
      this.pagination.currentPage = data.current_page;
      this.pagination.total = data.total;
      this.pagination.lastPageUrl = data.last_page_url;
      this.pagination.nextPageUrl = data.next_page_url;
      this.pagination.prevPageUrl = data.prev_page_url;
      this.pagination.from = data.from;
      this.pagination.to = data.to;
    },
    sortBy(key) {
      this.sortKey = key;
      this.sortOrders[key] = this.sortOrders[key] * -1;
      this.tableData.column = this.getIndex(this.columns, "name", key);
      this.tableData.dir = this.sortOrders[key] === 1 ? "asc" : "desc";
      this.getProjects();
    },
    getIndex(array, key, value) {
      return array.findIndex(i => i[key] == value);
    }
  }
};
</script>