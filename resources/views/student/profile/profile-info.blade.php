<div>
    <el-row :gutter="20" class="mt-3">
        <el-col>
            <label class="form-label mb-0" for="">Name</label>
            <input type="text" class="form-control" v-model="user.name" disabled />
        </el-col>
    </el-row>
    <el-row :gutter="20" class="mt-3">
        <el-col :span="16">
            <label class="form-label mb-0" for="">Birthday</label>
            <input type="text" class="form-control" v-model="user.birthdate" disabled />
        </el-col>
        <el-col :span="8">
            <label class="form-label mb-0" for="">Gender</label>
            <input type="text" class="form-control" v-model="user.gender" disabled />
        </el-col>
    </el-row>
    <el-row :gutter="20" class="mt-3 mb-5">
        <el-col>
            <label class="form-label mb-0" for="">Phone No</label>
            <input type="text" class="form-control" v-model="user.phone_number" disabled />
        </el-col>
    </el-row>
</div>