<div>
    <el-row :gutter="20" class="mt-3" v-if="!checkPass">
        <el-col>
            <label class="form-label mb-0" for=""><span class="text-danger">*</span> Current Password</label>
            <el-input placeholder="Enter Current Password" v-model="currentPassword" show-password></el-input>
            <span class="text-danger" v-text="currentPassErr"></span>
        </el-col>
    </el-row>
    <div v-else>
        <el-row :gutter="20" class="mt-3">
            <el-col>
                <label class="form-label mb-0" for=""><span class="text-danger">*</span> Input New
                    Password</label>
                <el-input placeholder="" v-model="newPassword" show-password></el-input>
                <span class="text-danger" v-text="newPassErr"></span>
            </el-col>
        </el-row>
        <el-row :gutter="20" class="mt-3">
            <el-col>
                <label class="form-label mb-0" for=""><span class="text-danger">*</span> Confirm
                    Password</label>
                <el-input placeholder="" v-model="confirmPassword" show-password></el-input>
                <span class="text-danger" v-text="confirmPassErr"></span>
            </el-col>
        </el-row>
    </div>
    <el-row :gutter="20" class="mt-5 mb-5">
        <el-col v-if="checkPass">
            <button class="btn btn-primary" v-if="loadButton" disabled><i class="el-icon-loading"></i> Loading</button>
            <button class="btn btn-primary" v-else @click="updatePassword">Update Password</button>
            <button class="btn btn-secondary" @click="resetPassword">Reset Form</button>
        </el-col>
        <el-col v-else>
            <button type="button" class="btn btn-primary" @click="checkPassword">Submit</button>
        </el-col>
    </el-row>
</div>
