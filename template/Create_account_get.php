<?php
if (isset($_SESSION['membership'])) {
    echo '<div class="alert alert-info" role="alert">' . $_SESSION['membership'] . '</div>';
    unset($_SESSION['membership']);
}
?>

<section>
    <div class="container">
        <h3 class="my-3">Create a new account</h3>
        <form action="/create_account" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">ชื่อ-นามสกุล</label>
                <input type="text" name="name" class="form-control"
                    placeholder="ชื่อ-นามสกุล" required>
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">เพศ</label>
                <select name="gender" class="form-control" required>
                    <option value="">Choose…</option>
                    <option value="ชาย">ชาย</option>
                    <option value="หญิง">หญิง</option>
                    <option value="ไม่ระบุ">ไม่ระบุ</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="birth_date" class="form-label">วันเกิด</label>
                <input type="date" name="birth_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="occupation" class="form-label">อาชีพ</label>
                <input type="text" name="occupation" class="form-control"
                    placeholder="อาชีพ" required>
            </div>

            <div class="mb-3">
                <label for="province" class="form-label">จังหวัด</label>
                <input type="text" name="province" class="form-control"
                    placeholder="จังหวัด" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control"
                    placeholder="Email address" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control"
                    placeholder="Password" required>
            </div>

            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>

        <p class="mt-3">
            Already have an account? <a href="/login">Login here</a>
        </p>
    </div>
</section>