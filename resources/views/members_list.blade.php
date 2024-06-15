<!doctype html>
<html lang="en">
<head>
    @include('includes.head')
</head>
<body>
<div id="member-list">
    <div class="row g-0 justify-content-center page-wrap">
        <div class="col-11 col-sm-10 col-md-9">
            <h2 class="page-heading text-center mb-4 mb-md-5">Member List</h2>
            <div class="box-card">
                <div class="add-btn">
                    {{--         button redirect to add member route    --}}
                    <a href="{{route('add.member.view')}}" class="btn btn-primary">Add Member</a>
                </div>
                <div class="row g-0">
                    <div class="col-md-12 form-pad">
                        <div class="table-responsive">
                            <table id="myTable" class="display">
                                <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Date of Birth</th>
                                    <th>DS Division</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="member in members" :key="member.id">
                                    <td>@{{ member.first_name }}</td>
                                    <td>@{{ member.last_name }}</td>
                                    <td>@{{ member.date_of_birth }}</td>
                                    <td>@{{ member.division }}</td>
                                    <td>
                                        <div class="table-btn-wrap">
                                            {{--         edit member route    --}}
                                            <a :href="'http://127.0.0.1:8000/edit/member/' + member.id" class="btn btn-primary">Edit</a>
                                            {{--        delete member route    --}}
                                            <button class="btn btn-danger" @click="removeMember(member.id)">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const MemberList = new Vue({
        el: '#member-list',
        data() {
            return {
                members: []
            }
        },
        methods: {
            // fetching all member data to the data table function
            async fetchMembers() {
                try {
                    const response = await axios.get('api/accura/members/list');
                    this.members = response.data.data;
                    $(document).ready(function () {
                        $('#myTable').DataTable();
                    });
                } catch (error) {
                    console.error('Error fetching members:', error);
                }
            },

            // remove member function
            async removeMember(memberId) {
                try {
                    const confirmed = await Swal.fire({
                        icon: 'warning',
                        title: 'Are you sure?',
                        text: 'You are about to remove this member. This action cannot be undone.',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, remove it!'
                    });

                    if (confirmed.isConfirmed) {
                        const response = await axios.post(`http://127.0.0.1:8000/api/remove/accura/member/${memberId}`);
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Member removed successfully!',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // after success response redirect to member list view
                            window.location.href = "{{ route('member.list') }}";
                        });
                    }
                } catch (error) {
                    console.error('Error removing member:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while removing member!',
                        confirmButtonText: 'OK'
                    });
                }
            }

        },
        mounted() {
            // initiate fetchMembers when component loads
            this.fetchMembers();

        },
    });
</script>
</body>
</html>
