import { Module } from '@nestjs/common'
import { ConfigModule, ConfigService } from '@nestjs/config'
import { TypeOrmModule } from '@nestjs/typeorm'
import { AppController } from './app.controller'
import { AuthModule } from './auth/auth.module'
import { OrdersModule } from './orders/orders.module'
import { ServicesModule } from './services/services.module'
import { StoresModule } from './stores/stores.module'
import { UsersModule } from './users/users.module'

@Module({
  imports: [
    ConfigModule.forRoot({ isGlobal: true }),
    TypeOrmModule.forRootAsync({
      inject: [ConfigService],
      useFactory: (config: ConfigService) => ({
        type: 'postgres' as const,
        host: config.get<string>('DB_HOST', '127.0.0.1'),
        port: config.get<number>('DB_PORT', 5432),
        username: config.get<string>('DB_USERNAME', 'postgres'),
        password: config.get<string>('DB_PASSWORD', ''),
        database: config.get<string>('DB_DATABASE', 'laundry_desk'),
        autoLoadEntities: true,
        synchronize: false
      })
    }),
    AuthModule, UsersModule, StoresModule, ServicesModule, OrdersModule
  ],
  controllers: [AppController]
})
export class AppModule {}
