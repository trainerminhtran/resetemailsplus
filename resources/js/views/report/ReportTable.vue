<template>
  <div class="app-container">
    <div class="filter-container">
      <el-card class="box-card">
        <div>
          <el-row>
            <el-col :span="5">
              <el-col :span="24"><span>Tóm Tắt</span></el-col>
              <el-col v-for="item in reportTotal" :key="item" :span="24" style="color: #1890ff;font-weight: 700;font-size: 20px;">
                <el-row>
                  <el-col :span="24"><span>Số Request trong ngày :</span>  <span v-if="item.computed">{{ item.computed }} </span> </el-col>
                </el-row>
                <el-row>
                  <el-col :span="24"><span>Số Request trong tuần :</span> <span v-if="item.computed1">{{ item.computed1 }} </span></el-col>
                </el-row>
                <el-row>
                  <el-col :span="24"><span>Số Request trong tháng :</span> <span v-if="item.computed2">{{ item.computed2 }} </span></el-col>
                </el-row>
              </el-col>
            </el-col>
          </el-row>
        </div>
      </el-card>
      <el-date-picker ref="selectedDate" key="selectDate" v-model="listQuery.selecteddate" type="daterange" format="yyyy-MM-dd" value-format="yyyy-MM-dd" start-placeholder="Start date" end-placeholder="End date" :default-value="selectedDate" />
      <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">
        {{ $t('table.search') }}
      </el-button>
    </div>

    <el-table
      :key="tableKey"
      v-loading="listLoading"
      :data="list"
      border
      fit
      highlight-current-row
      style="width: 100%;"
      @sort-change="sortChange"
    >
      <el-table-column :label="$t('table.id')" prop="id" sortable="custom" align="center" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.Id }}</span>
        </template>
      </el-table-column>
      <el-table-column label="UserName" width="150px" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.UserName }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Email" width="150px" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.Email }}</span>
        </template>
      </el-table-column>
      <el-table-column label="CreateDate" width="150px" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.CreateDate }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Status" class-name="status-col" width="100">
        <template slot-scope="{row}">
          <el-tag :type="row.Status | statusFilter">
            {{ row.Status || statusFilter }}
          </el-tag>
        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
  </div>
</template>

<script>
import waves from '@/directive/waves'; // Waves directive
import { parseTime } from '@/utils';
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
import Resource from '@/api/resource';
const ReportResource = new Resource('report');
const calendarTypeOptions = [
  { key: 'CN', display_name: 'China' },
  { key: 'US', display_name: 'USA' },
  { key: 'JA', display_name: 'Japan' },
  { key: 'VI', display_name: 'Vietnam' },
];

// arr to obj ,such as { CN : "China", US : "USA" }
const calendarTypeKeyValue = calendarTypeOptions.reduce((acc, cur) => {
  acc[cur.key] = cur.display_name;
  return acc;
}, {});

export default {
  name: 'ReportTable',
  components: { Pagination },
  directives: { waves },
  filters: {
    statusFilter(status) {
      const statusMap = {
        1: 'success',
        0: 'fails',
      };
      return statusMap[status];
    },
    typeFilter(type) {
      return calendarTypeKeyValue[type];
    },
  },
  data() {
    var now = new Date();
    var startDate = new Date(Date.UTC(now.getFullYear(), now.getMonth(), now.getDate() - 30)).toISOString().slice(0, 10);
    var endDate = new Date(Date.UTC(now.getFullYear(), now.getMonth(), now.getDate())).toISOString().slice(0, 10);
    this.date = [];
    this.date.push(startDate);
    this.date.push(endDate);
    return {
      selectedDate: this.date,
      tableKey: 0,
      list: null,
      reportTotal: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 20,
        selecteddate: this.date,
        filter: '',
      },
      importanceOptions: [1, 2, 3],
      showReviewer: false,
      dialogFormVisible: false,
      dialogStatus: '',
      dialogPvVisible: false,
      pvData: [],
      downloadLoading: false,
    };
  },
  created() {
    this.getList();
  },
  methods: {
    showPwd() {
      if (this.pwdType === 'password') {
        this.pwdType = '';
      } else {
        this.pwdType = 'password';
      }
    },
    async getList() {
      // this.listLoading = true;
      const { data } = await ReportResource.list(this.listQuery);
      this.reportTotal = data;
      // Just to simulate the time of the request
      // this.listLoading = false;
    },
    async getListAll() {
      // this.listLoading = true;
      const { data } = await ReportResource.list(this.listQuery);
      this.list = data;
      this.list.forEach((element, index) => {
        if (element['Status'] === 1){
          element['Status'] = 'Thành Công';
        } else {
          element['Status'] = 'Thất Bại';
        }
      });
      // Just to simulate the time of the request
      this.listLoading = false;
    },
    handleFilter() {
      this.listQuery.page = 1;
      this.listQuery.filter = 'filter';
      this.getListAll();
    },
    sortChange(data) {
      const { prop, order } = data;
      if (prop === 'id') {
        this.sortByID(order);
      }
    },
    sortByID(order) {
      if (order === 'ascending') {
        this.listQuery.sort = '+id';
      } else {
        this.listQuery.sort = '-id';
      }
      this.handleFilter();
    },
    resetTemp() {
      this.temp = {
        id: undefined,
        username: '',
        password: '',
        status: 'published',
      };
    },
    handleCreate() {
      this.resetTemp();
      this.dialogStatus = 'create';
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate();
      });
    },
    handleDelete(row) {
      this.$notify({
        title: 'Success',
        message: 'Deleted successfully',
        type: 'success',
        duration: 2000,
      });
      const index = this.list.indexOf(row);
      this.list.splice(index, 1);
    },
    handleDownload() {
      this.downloadLoading = true;
      import('@/vendor/Export2Excel').then(excel => {
        const tHeader = ['timestamp', 'title', 'type', 'importance', 'status'];
        const filterVal = ['timestamp', 'title', 'type', 'importance', 'status'];
        const data = this.formatJson(filterVal, this.list);
        excel.export_json_to_excel({
          header: tHeader,
          data,
          filename: 'table-list',
        });
        this.downloadLoading = false;
      });
    },
    formatJson(filterVal, jsonData) {
      return jsonData.map(v => filterVal.map(j => {
        if (j === 'timestamp') {
          return parseTime(v[j]);
        } else {
          return v[j];
        }
      }));
    },
  },
};
</script>
<style>
  .el-card.is-always-shadow{
    box-shadow: none;
    border: navajowhite;
  }
</style>
