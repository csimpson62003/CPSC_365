function logout() {
    // Clear all cookies
    console.log(document.cookie)
    document.cookie.split(";").forEach(c => {
        document.cookie = c.trim().split("=")[0] + "=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/";
    });
    // Redirect to the home page or login page
    window.location.href = "index.php"; // Update the URL as needed
}