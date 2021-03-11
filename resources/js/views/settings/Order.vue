<template>
  <div class="app-container">
    <el-card>
      <div slot="header" class="clearfix">
        <span>Cài đặt kho</span>
        <el-button style="float: right;" type="success" @click="submit">Lưu</el-button>
      </div>
      <div class="text item d-flex just-content-between-space">
        <div>
          <h3>{{ 'Cài đặt scan đơn hàng' }}</h3>
          <p class="explain">Cấu hình mở popup thông tin đơn hàng hoặc chuyển trạng thái ngay</p>
        </div>
        <div>
          <el-radio v-model="is_popup_order" label="1" border>Mở popup</el-radio>
          <el-radio v-model="is_popup_order" label="0" border>Tắt popup</el-radio>
        </div>
      </div>
    </el-card>
  </div>
</template>

<script>
import waves from '@/directive/waves';
import Settings from '@/api/setting';
const settingResource = new Settings();
export default {
  name: 'Settings',
  directives: { waves },
  filters: {
    statusFilter(status) {
      const statusMap = {
        published: 'success',
        draft: 'info',
        deleted: 'danger',
      };
      return statusMap[status];
    },
  },
  data() {
    return {
      setting: {
        is_popup_order: true,
      },
      is_popup_order: '',
    };
  },
  created() {
    this.getSetting();
  },
  methods: {
    async getSetting() {
      const { data } = await settingResource.list();
      this.setting = data;
      this.is_popup_order = data.is_popup_order === false ? '0' : '1';
    },
    async submit() {
      const data = {
        is_popup_order: this.is_popup_order,
        is_stock: this.setting.is_stock === true ? '1' : '0',
        number_out_of_stock: parseInt(this.setting.number_out_of_stock, 10),
        combo_keyword: this.setting.combo_keyword,
        map_by: this.setting.map_by,
      };
      await settingResource.update(this.setting._id, data);

      this.$message({
        type: 'success',
        message: 'Cập nhật trạng thái thành công',
      });
    },
  },
};
</script>

<style>
  .text {
    font-size: 14px;
  }

  .item {
    margin-bottom: 18px;
  }

  .clearfix:before,
  .clearfix:after {
    display: table;
    content: "";
  }
  .clearfix:after {
    clear: both
  }

  .box-card {
    width: 480px;
  }
  .d-flex {
    display: flex;
  }
  .just-content-between-space {
    justify-content: space-between;
  }
  .explain {
    color: #757575
  }
</style>
