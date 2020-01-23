export const Roles = {
  Admin: 'admin',
  Creator: 'creator',
  Student: 'student',

  onlyAdminsAndCreators(rolName) {
    return rolName == this.Admin || rolName == this.Creator
  }
}
