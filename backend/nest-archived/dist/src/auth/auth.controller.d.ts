declare class LoginDto {
    email: string;
    password: string;
}
export declare class AuthController {
    login(_credentials: LoginDto): {
        message: string;
    };
}
export {};
