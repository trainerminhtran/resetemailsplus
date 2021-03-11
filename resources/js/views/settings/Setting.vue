<template>
  <div class="app-container">
    <el-card>
      <div slot="header" class="clearfix">
        <span>Cài đặt kho</span>
        <el-button style="float: right;" type="success" @click="submit">Lưu</el-button>
      </div>
      <div class="text item d-flex just-content-between-space">
        <div>
          <h3>{{ 'Cập nhật Kho' }}</h3>
          <p class="explain">Cấu hình có cập nhật giá trị kho khi sản phẩm được cập nhật</p>
        </div>
        <div>
          <el-radio v-model="is_stock" label="1" border>Bật cập nhật</el-radio>
          <el-radio v-model="is_stock" label="0" border>Tắt cập nhật</el-radio>
        </div>
      </div>
      <div class="text item d-flex just-content-between-space">
        <div>
          <h3>{{ 'Số lượng cảnh báo khi sắp hết hàng' }}</h3>
          <p class="explain">Cấu hình số lượng sản phẩm được xem là sắp hết hàng</p>
        </div>
        <div>
          <el-input-number v-model="number_out_of_stock" :min="0" @change="handleOutOfStock" />
        </div>
      </div>
      <div class="text item d-flex just-content-between-space">
        <div>
          <h3>{{ 'Cấu hình map kho' }}</h3>
          <p class="explain">Cấu hình map kho theo sku hoặc tên sản phẩm</p>
        </div>
        <div>
          <el-select v-model="setting.map_by" multiple placeholder="Select">
            <el-option
              v-for="item in map_by"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </div>
      </div>
      <div class="text item d-flex just-content-between-space">
        <div>
          <h3>{{ 'Cấu hình map combo' }}</h3>
          <p class="explain">Cấu hình kí tự combo xuất hiện trong sku hoặc tên sản phẩm</p>
        </div>
        <div>
          <el-select
            v-model="setting.combo_keyword"
            multiple
            filterable
            allow-create
            default-first-option
            placeholder="Choose tags for your article"
          >
            <el-option
              v-for="item in combo_keyword"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </div>
      </div>
    </el-card>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import waves from '@/directive/waves'; // Waves directive
import Settings from '@/api/setting';
const stockResource = new Resource('stocks');
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
        is_stock: true,
        number_out_of_stock: 0,
        combo_keyword: [],
        map_by: [],
      },
      is_stock: '',
      number_out_of_stock: 0,
      combo_keyword: [
        {
          value: '+',
          label: '+',
        }, {
          value: 'combo',
          label: 'combo',
        },
      ],
      map_by: [
        {
          value: 'sku',
          label: 'SKU',
        }, {
          value: 'name',
          label: 'Tên sản phẩm',
        },
      ],
    };
  },
  created() {
    this.getSetting();
    console.log(this.setting);
  },
  methods: {
    async getSetting() {
      const { data } = await settingResource.list();
      this.setting = data;
      this.is_stock = data.is_stock === true ? '1' : '0';
      this.number_out_of_stock = parseInt(data.number_out_of_stock, 10);
    },
    async checkStoreStock() {
      await stockResource.isStoreStock({ is_stock: this.is_stock });

      this.$message({
        type: 'success',
        message: 'Cập nhật trạng thái thành công',
      });
    },
    async handleOutOfStock() {
      this.setting.number_out_of_stock = parseInt(this.number_out_of_stock, 10);
    },
    async submit() {
      const data = {
        is_stock: this.is_stock,
        number_out_of_stock: parseInt(this.setting.number_out_of_stock, 10),
        combo_keyword: this.setting.combo_keyword,
        map_by: this.setting.map_by,
      };
      await settingResource.update(this.setting._id, data);
      await stockResource.isStoreStock({ is_stock: this.is_stock });

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
