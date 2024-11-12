<body class="credit">
  <div class="col-sm-8 mx-auto">
    <form action="terimacredit.php" method="post">
      <table class="table table-striped table-hover table-light mx-auto">
        <tr class="table-dark">
          <th colspan="3" class="text-center">SIMULASI KREDIT MOTOR</th>
        </tr>
        <tr>
          <td class="fw-medium" style="width: 40%;">
            <label>Harga Motor </label>
          </td>
          <td>
            <input type="number" class="form-control" id="harga_motor" name="harga_motor" min="0" required>
          </td>
          <td>Rupiah</td>
        </tr>
        <tr>
          <td class="fw-medium">
            <label>Uang Muka (DP) </label>
          </td>
          <td>
            <input type="number" class="form-control" id="uang_muka" name="uang_muka" min="10" max="100" step="1"
              required>
          </td>
          <td>%</td>
        </tr>
        <tr>
          <td class="fw-medium">
            <label>Jangka Waktu</label>
          </td>
          <td>
            <input type="number" class="form-control" id="tenor" name="tenor" min="1" max="10" required>
          </td>
          <td>Tahun</td>
        </tr>
        <tr>
          <td class="fw-medium">
            <label>Margin Bank</label>
          </td>
          <td>
            <input type="number" class="form-control" id="bunga_pinjaman" name="bunga_pinjaman" min="3" max="10"
              step="0.01" required>
          </td>
          <td>%</td>
        </tr>
        <tr>
          <td class="fw-medium">
            <label>Perhitungan Margin </label>
          </td>
          <td>
            <select name="motor_anda" class="form-control" required>
              <option value="Flat">Flat</option>
              <option value="Floating">Floating</option>
              <option value="Fixed">Fixed</option>
              <option value="Effective">Effective</option>
              <option value="Annuity">Annuity</option>
            </select>
          </td>
          <td></td>
        </tr>
        <tr>
          <td colspan="3" class="text-center">
            <button type="submit"
              class="fw-medium link-dark link-underline link-underline-opacity-0 link-opacity-50-hover">
              Kalkulasi
            </button>
          </td>
        </tr>
      </table>
    </form>
  </div>
</body>