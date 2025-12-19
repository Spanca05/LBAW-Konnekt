function updateJobPosts() {
    fetch('/profile/jobposts-status', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('active_jobposts_list').innerHTML = data.active || '<p>No active job posts</p>';
        document.getElementById('expired_jobposts_list').innerHTML = data.expired || '<p>No expired job posts</p>';
    })
    .catch(err => console.error(err));
}

// Atualiza a cada 5s
setInterval(updateJobPosts, 1000);
updateJobPosts();
