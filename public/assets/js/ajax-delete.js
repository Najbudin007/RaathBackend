function confirmDelete(url, key, token) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, proceed it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: url,
                data: '_token=' + token,
                success: function (data) {
                    if (data.success) {
                        $('#row_' + key).remove();
                        Swal.fire(
                            'Deleted!',
                            data.message || 'Data has been deleted.',
                            'success'
                        );
                    } else {
                        Swal.fire(
                            'Error!',
                            data.message || 'Failed to delete data.',
                            'error'
                        );
                    }
                },
                error:function (xhr, ajaxOptions, thrownError){
                    let errorMessage = 'There are some error. Please contact developer';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    switch (xhr.status) {
                        case 404:
                            Swal.fire(
                                'Not Found',
                                errorMessage,
                                'error'
                            )
                        break;
                        case 403:
                            Swal.fire(
                                'Permission Denied',
                                errorMessage,
                                'warning'
                            )
                            break;
                        case 419:
                            Swal.fire(
                                'Session Expired',
                                'Please refresh the page and try again',
                                'info'
                            )
                            break;
                        case 500:
                            Swal.fire(
                                'Server Error',
                                'Internal server error. Please try again later.',
                                'error'
                            )
                            break;
                        default:
                            Swal.fire(
                                'Error',
                                errorMessage,
                                'error'
                            )
                    }

                }

            });

        }
    })
}

// Toggle status function
function toggleStatus(url, key, token, currentStatus) {
    const action = currentStatus === 'true' ? 'deactivate' : 'activate';
    
    Swal.fire({
        title: `Are you sure?`,
        text: `Do you want to ${action} this user?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: `Yes, ${action} it!`
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    '_token': token,
                    '_method': 'POST'
                },
                success: function (data) {
                    if (data.success) {
                        // Reload the page to update the status
                        location.reload();
                        Swal.fire(
                            'Success!',
                            data.message || `User ${action}d successfully.`,
                            'success'
                        );
                    } else {
                        Swal.fire(
                            'Error!',
                            data.message || `Failed to ${action} user.`,
                            'error'
                        );
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    let errorMessage = `Failed to ${action} user.`;
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    Swal.fire(
                        'Error!',
                        errorMessage,
                        'error'
                    );
                }
            });
        }
    });
}
