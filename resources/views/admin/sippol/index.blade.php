<form action="{{ route('sipd.read.bp22') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required>
    <button type="submit">Read Excel</button>
</form>
