import { ValidationPipe } from '@nestjs/common'
import { NestFactory } from '@nestjs/core'
import { AppModule } from './app.module'

async function bootstrap() {
  const app = await NestFactory.create(AppModule)
  const origins = (process.env.CORS_ORIGIN ?? 'http://localhost:5173,http://localhost:1420').split(',')
  app.enableCors({ origin: origins, credentials: true })
  app.setGlobalPrefix('api')
  app.useGlobalPipes(new ValidationPipe({ whitelist: true, transform: true, forbidNonWhitelisted: true }))
  await app.listen(Number(process.env.PORT ?? 3000))
}

void bootstrap()
