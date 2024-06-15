<!doctype html>
<html lang="en">
<head>
    @include('includes.head')
</head>
<body>
<div id="member-add">
    <div class="row g-0 justify-content-center page-wrap">
        <div class="col-11 col-sm-10 col-md-9">
            <h2 class="page-heading text-center mb-4 mb-md-5">Add Member</h2>

            <div class="box-card">
                <div class="back-btn">
                    <img src="{{asset('images/back.png')}}" alt="back icon"/>
                    <a href="{{route('member.list')}}" style="text-decoration: none;"><p>Back</p></a>
                </div>
                <div class="row form-mar">
                    <div class="col-md-6 form-pad">
                        <div class="mb-4">
                            <input v-model="memberData.first_name" type="text" class="form-control page-input"
                                   id="first_name" name="first_name"
                                   placeholder="First Name" required>
                            <div v-if="errorMessages.first_name !== ''" class="text-danger">@{{ errorMessages.first_name }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 form-pad">
                        <div class="mb-4">
                            <input v-model="memberData.last_name" type="text" class="form-control page-input" id="last_name"
                                   name="last_name"
                                   placeholder="Last Name" required>
                            <div v-if="errorMessages.last_name !== ''" class="text-danger">@{{ errorMessages.last_name }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 form-pad">
                        <div class="mb-4">
                            <select v-model="memberData.division_id" class="form-select page-input select"
                                    aria-label="Default select example" required>
                                <option disabled value="">DS Division</option>
                                <option v-for="division in divisions" :key="division.id" :value="division.id">@{{ division.name }}
                                </option>
                            </select>
                            <div v-if="errorMessages.division_id !== ''" class="text-danger">@{{ errorMessages.division_id }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 form-pad">
                        <div class="mb-4">
                            <input v-model="memberData.date_of_birth" type="date" class="form-control page-input" required>
                            <div v-if="errorMessages.date_of_birth !== ''" class="text-danger">@{{ errorMessages.date_of_birth }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 form-pad">
                        <div class="mb-4">
                        <textarea v-model="memberData.summary" class="form-control page-input" rows="4" name="summary"
                                  placeholder="Summary" required></textarea>
                            <div v-if="errorMessages.summary !== ''" class="text-danger">@{{ errorMessages.summary }}</div>
                        </div>
                    </div>

                    <div class="col-12 btn-wrap mt-4 mt-md-5">
                        <button type="button" class="btn btn-danger page-btn" @click="resetForm()">Reset</button>
                        <button v-if="!isEdit" type="button" class="btn btn-primary page-btn" @click="saveMemberData()">
                            Save
                        </button>
                        <button v-if="isEdit" type="button" class="btn btn-primary page-btn" @click="updateMemberData()">
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

    const MemberList = new Vue({
        el: '#member-add',
        data() {
            return {
                // form data
                memberData: {
                    first_name: '',
                    last_name: '',
                    division_id: '',
                    date_of_birth: '',
                    summary: '',
                },

                // error messages
                errorMessages: {
                    first_name: '',
                    last_name: '',
                    division_id: '',
                    date_of_birth: '',
                    summary: '',
                },

                divisions: [],
                selectedDivision: '',
                isEdit: false,
                selectedMemberId: null
            }
        },
        methods: {
            // fetching division function
            async fetchDivisions() {
                try {
                    const response = await axios.get('http://127.0.0.1:8000/api/ds/divisions/list');
                    this.divisions = response.data.data;
                } catch (error) {
                    console.error('Error fetching divisions:', error);
                }
            },

            // fetching member data function
            async fetchMemberData() {
                try {
                    console.log('this.selectedMemberId22', this.selectedMemberId)
                    const response = await axios.get('http://127.0.0.1:8000/api/accura/member/' + this.selectedMemberId);
                    this.memberData.first_name = response.data.data.fname;
                    this.memberData.last_name = response.data.data.lname;
                    this.memberData.date_of_birth = response.data.data.d_o_b;
                    this.memberData.division_id = response.data.data.ds_division_id;
                    this.memberData.summary = response.data.data.summary;
                } catch (error) {
                    console.error('Error fetching divisions:', error);
                }
            },

            // save member data function
            async saveMemberData() {
                this.errorMessages = {
                    first_name: '',
                    last_name: '',
                    division_id: '',
                    date_of_birth: '',
                    summary: '',
                };

                // form validation handle
                if (!this.memberData.first_name) {
                    this.errorMessages.first_name = "First name is required";
                    return;
                }
                if (!this.memberData.last_name) {
                    this.errorMessages.last_name = "Last name is required";
                    return;
                }
                if (!this.memberData.division_id) {
                    this.errorMessages.division_id = "Division is required";
                    return;
                }
                if (!this.memberData.date_of_birth) {
                    this.errorMessages.date_of_birth = "Date of birth is required";
                    return;
                }
                if (new Date(this.memberData.date_of_birth) >= new Date()) {
                    this.errorMessages.date_of_birth = "Date of birth must be before today";
                    return;
                }
                if (!this.memberData.summary) {
                    this.errorMessages.summary = "Summary is required";
                    return;
                }

                try {
                    const response = await axios.post('http://127.0.0.1:8000/api/add/accura/member', this.memberData);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Member data saved successfully!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = "{{ route('member.list') }}";
                    });
                } catch (error) {
                    console.error('Error saving member data:', error);
                }
            },

            // update member data function
            async updateMemberData() {
                this.errorMessages = {
                    first_name: '',
                    last_name: '',
                    division_id: '',
                    date_of_birth: '',
                    summary: '',
                };

                if (!this.memberData.first_name) {
                    this.errorMessages.first_name = "First name is required";
                    return;
                }
                if (!this.memberData.last_name) {
                    this.errorMessages.last_name = "Last name is required";
                    return;
                }
                if (!this.memberData.division_id) {
                    this.errorMessages.division_id = "Division is required";
                    return;
                }
                if (!this.memberData.date_of_birth) {
                    this.errorMessages.date_of_birth = "Date of birth is required";
                    return;
                }
                if (new Date(this.memberData.date_of_birth) >= new Date()) {
                    this.errorMessages.date_of_birth = "Date of birth must be before today";
                    return;
                }
                if (!this.memberData.summary) {
                    this.errorMessages.summary = "Summary is required";
                    return;
                }

                try {
                    const response = await axios.post('http://127.0.0.1:8000/api/update/accura/member/' + this.selectedMemberId, this.memberData);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Member data updated successfully!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = "{{ route('member.list') }}";
                    });
                } catch (error) {
                    console.error('Error saving member data:', error);
                }
            },

            // reset form function
            resetForm() {
                this.memberData = {
                    first_name: '',
                    last_name: '',
                    division_id: '',
                    date_of_birth: '',
                    summary: '',
                };
            }
        },

        mounted() {
            // fetch divisions initiation
            this.fetchDivisions();

            // checking whether edit
            if (window.location.href.includes('http://127.0.0.1:8000/edit/member/')) {
                this.isEdit = true;
                const urlParts = window.location.href.split('/');
                const memberId = urlParts[urlParts.length - 1];
                this.selectedMemberId = memberId;
                console.log('this.selectedMemberId', this.selectedMemberId)
            }
            // fetch specific member data
            this.fetchMemberData();
        },
        watch: {
            'memberData.first_name'(newValue, oldValue) {
                if (newValue !== '') {
                    this.errorMessages.first_name = '';
                }
            },
            'memberData.last_name'(newValue, oldValue) {
                if (newValue !== '') {
                    this.errorMessages.last_name = '';
                }
            },
            'memberData.division_id'(newValue, oldValue) {
                if (newValue !== '') {
                    this.errorMessages.division_id = '';
                }
            },
            'memberData.date_of_birth'(newValue, oldValue) {
                if (newValue !== '') {
                    this.errorMessages.date_of_birth = '';
                }
            },
            'memberData.summary'(newValue, oldValue) {
                if (newValue !== '') {
                    this.errorMessages.summary = '';
                }
            },

            'memberData.date_of_birth'(newValue, oldValue) {
                const today = new Date();
                const selectedDate = new Date(newValue);
                if (selectedDate > today || selectedDate.toDateString() === today.toDateString()) {
                    this.errorMessages.date_of_birth = "Date of birth must be before today";
                } else {
                    this.errorMessages.date_of_birth = "";
                }
            },
            'memberData.division_id'(newValue) {
                this.selectedDivision = this.divisions.find(division => division.id === newValue);
            }
        }

    });
</script>

</body>
</html>
