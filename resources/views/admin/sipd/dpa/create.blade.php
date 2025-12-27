<form action="{{ route('sipd.dpa.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="json_file">Select JSON File id_ket_sub_bl :</label><br>
    <input type="file" id="id_ket_sub_bl" name="id_ket_sub_bl" accept=".json" required><br>
    <label for="json_file">Select JSON File id_subs_sub_bl :</label><br>
    <input type="file" id="id_subs_sub_bl" name="id_subs_sub_bl" accept=".json" required><br>
    <label for="json_file">Select JSON File id_rinci_sub_bl:</label><br>
    <input type="file" id="id_rinci_sub_bl" name="id_rinci_sub_bl" accept=".json" required><br>
    <button type="submit">Upload</button>
</form>