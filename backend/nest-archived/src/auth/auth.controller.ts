import { Body, Controller, Post } from '@nestjs/common'

type LoginDto = { email: string; password: string }
@Controller('auth')
export class AuthController {
  @Post('login')
  login(@Body() _credentials: LoginDto) { return { message: 'Endpoint login siap. JWT akan ditambahkan setelah entitas pengguna dibuat.' } }
}
